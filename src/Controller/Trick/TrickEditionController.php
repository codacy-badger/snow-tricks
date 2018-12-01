<?php

namespace App\Controller\Trick;

use App\Form\Trick\EditTrickType;
use App\IO\EmbedVideo\VideoPlatformMatcher;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\ModifyTrickDTO;
use App\Model\Entity\Photo;
use App\Model\Entity\Trick;
use App\Model\Entity\Video;
use App\Repository\PhotoRepository;
use App\Repository\TrickGroupRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickEditionController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TrickGroupRepository
     */
    private $trickGroupRepository;

    /**
     * @var Slugger
     */
    private $slugger;

    /**
     * @var PhotoRepository
     */
    private $photoRepository;

    /**
     * @var TrickPhotoUploader
     */
    private $trickPhotoUploader;

    /**
     * @var VideoRepository
     */
    private $videoRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        TrickRepository $trickRepository,
        UserRepository $userRepository,
        TrickGroupRepository $trickGroupRepository,
        PhotoRepository $photoRepository,
        TrickPhotoUploader $trickPhotoUploader,
        VideoRepository $videoRepository,
        Slugger $slugger,
        EntityManagerInterface $entityManager
    ) {
        $this->trickRepository = $trickRepository;
        $this->userRepository = $userRepository;
        $this->trickGroupRepository = $trickGroupRepository;
        $this->photoRepository = $photoRepository;
        $this->trickPhotoUploader = $trickPhotoUploader;
        $this->videoRepository = $videoRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/trick/edit/{slug}", name="trick_edit")
     * @IsGranted("ROLE_USER")
     */
    public function edit(Trick $trick, Request $request): Response
    {
        $modifyTrickDTO = new ModifyTrickDTO($trick);
        $trickForm = $this->createForm(EditTrickType::class, $modifyTrickDTO);

        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick = Trick::modify($modifyTrickDTO);

            $trick->updateVideos($modifyTrickDTO->getVideos(), $this->entityManager);

            $trick->updatePhotos($modifyTrickDTO->getPhotos(),$this->trickPhotoUploader);

/*            foreach ($modifyTrickDTO->getVideos() as $addVideoLinkDTO) {
                $videoMeta = VideoPlatformMatcher::match($addVideoLinkDTO);

                if (!$video = $this->videoRepository->findOneBy(['videoCode' => $videoMeta->getCode()])) {
                    $video = Video::create($videoMeta);

                    $this->entityManager->persist($video);
                }
                $trick->addVideo($video);
            }*/
/*
            $fileArray = $modifyTrickDTO->getPhotos();

            foreach ($fileArray as $file) {
                $filename = $this->trickPhotoUploader->upload($file);

                $photo = Photo::create($filename, $trick);
                $trick->addPhoto($photo);
            }*/

            $this->trickRepository->save($trick);

            $this->addFlash('success', 'trick.success.modification');

            return $this->redirectToRoute('trick_edit', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trickForm' => $trickForm->createView(),
            'trick' => $trick,
        ]);
    }
}
