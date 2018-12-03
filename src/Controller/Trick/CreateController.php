<?php

namespace App\Controller\Trick;

use App\Form\Trick\CreateTrickType;
use App\IO\EmbedVideo\VideoPlatformMatcher;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\Entity\Photo;
use App\Model\Entity\Trick;
use App\Model\Entity\Video;
use App\Utils\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    /**
     * @var Slugger
     */
    private $slugger;

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
        TrickPhotoUploader $trickPhotoUploader,
        Slugger $slugger,
        EntityManagerInterface $entityManager
    ) {
        $this->slugger = $slugger;
        $this->trickPhotoUploader = $trickPhotoUploader;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/trick/create", name="trick_create")
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request): Response
    {
        $createTrickDTO = new CreateTrickDTO($this->getUser());

        $trickForm = $this->createForm(CreateTrickType::class, $createTrickDTO);

        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $slug = $this->slugger->slugify($createTrickDTO->getName());

            $this->trick = Trick::create($createTrickDTO, $slug);

            $this->updateVideos($createTrickDTO->getVideos());

            $this->updatePhotos($createTrickDTO->getPhotos());

            $this->entityManager->persist($this->trick);

            $this->entityManager->flush();

            $this->addFlash('success', 'trick.success.creation');

            return $this->redirectToRoute('trick_show', ['slug' => $this->trick->getSlug()]);
        }

        return $this->render('trick/new.html.twig', [
            'trickForm' => $trickForm->createView(),
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
