<?php

namespace App\Controller\Trick;

use App\Form\Trick\EditTrickType;
use App\IO\EmbedVideo\VideoPlatformMatcher;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\ModifyTrickDTO;
use App\Model\Entity\Photo;
use App\Model\Entity\Trick;
use App\Model\Entity\Video;
use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var TrickPhotoUploader
     */
    private $trickPhotoUploader;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Trick
     */
    private $trick;

    public function __construct(
        TrickRepository $trickRepository,
        TrickPhotoUploader $trickPhotoUploader,
        EntityManagerInterface $entityManager
    ) {
        $this->trickRepository = $trickRepository;
        $this->trickPhotoUploader = $trickPhotoUploader;
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
            $this->trick = Trick::modify($modifyTrickDTO);

            $this->updateVideos($modifyTrickDTO->getVideos());

            $this->updatePhotos($modifyTrickDTO->getPhotos());

            $this->trickRepository->save($trick);

            $this->addFlash('success', 'trick.success.modification');

            return $this->redirectToRoute('trick_edit', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trickForm' => $trickForm->createView(),
            'trick' => $trick,
        ]);
    }

    private function updateVideos(ArrayCollection $videosCollection)
    {
        foreach ($videosCollection as $addVideoLinkDTO) {
            $videoMeta = VideoPlatformMatcher::match($addVideoLinkDTO);

            if (!$video =
                $this->entityManager->getRepository(Video::class)
                    ->findOneBy(['videoCode' => $videoMeta->getCode()])
            ) {
                $video = Video::create($videoMeta);
                $this->entityManager->persist($video);
            }

            $this->trick->addVideo($video);
        }
    }

    private function updatePhotos(array $fileArray)
    {
        foreach ($fileArray as $file) {
            $filename = $this->trickPhotoUploader->upload($file);

            $photo = Photo::create($filename, $this->trick);

            $this->trick->addPhoto($photo);
        }
    }
}
