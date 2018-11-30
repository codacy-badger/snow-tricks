<?php

namespace App\Controller;

use App\Form\Trick\CreateTrickType;
use App\Form\Trick\EditTrickType;
use App\IO\EmbedVideo\VideoPlatformMatcher;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\CreateTrickDTO;
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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
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
        $this->slugger = $slugger;
        $this->photoRepository = $photoRepository;
        $this->trickPhotoUploader = $trickPhotoUploader;
        $this->videoRepository = $videoRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $tricks = $this->trickRepository->findAll();

        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/trick/show/{slug}", name="trick_show")
     */
    public function show(Trick $trick): Response
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
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

            $videosCollection = new ArrayCollection();

            // todo: ajouter method update video( (et update photos pour les photos) dans Trick,
            // todo: a mettre après la création du trick
            foreach ($createTrickDTO->getVideos() as $addVideoLinkDTO) {
                $videoMeta = VideoPlatformMatcher::match($addVideoLinkDTO);

                if (!$video = $this->videoRepository->findOneBy(['videoCode' => $videoMeta->getCode()])) {

                    $video = Video::create($videoMeta);

                    $this->entityManager->persist($video);
                }

                $videosCollection[] = $video;
            }

            $trick = Trick::create($createTrickDTO, $slug, $videosCollection);

            $fileArray = $createTrickDTO->getPhotos();

            foreach ($fileArray as $file) {
                $filename = $this->trickPhotoUploader->upload($file);

                $photo = Photo::create($filename, $trick);
                $trick->addPhoto($photo);
            }

            $this->entityManager->persist($trick);

            $this->entityManager->flush();

            $this->addFlash('success', 'trick.success.creation');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/new.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
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

            foreach ($modifyTrickDTO->getVideos() as $addVideoLinkDTO) {
                $videoMeta = VideoPlatformMatcher::match($addVideoLinkDTO);

                if (!$video = $this->videoRepository->findOneBy(['videoCode' => $videoMeta->getCode()])) {

                    $video = Video::create($videoMeta);

                    $this->entityManager->persist($video);
                }
                $trick->addVideo($video);
            }


            $fileArray = $modifyTrickDTO->getPhotos();

            foreach ($fileArray as $file) {
                $filename = $this->trickPhotoUploader->upload($file);

                $photo = Photo::create($filename, $trick);
                $trick->addPhoto($photo);
            }

            $this->trickRepository->save($trick);

            $this->addFlash('success', 'trick.success.modification');

            return $this->redirectToRoute('trick_edit', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trickForm' => $trickForm->createView(),
            'trick' => $trick,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/trick/delete/{slug}", name="trick_delete")
     */
    public function delete(Trick $trick): Response
    {
        $this->trickRepository->remove($trick);

        $this->addFlash('success', 'trick.success.deletion');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/trick/{slug}/video/{id}/delete", name="trick_remove_video")
     * @ParamConverter("trick", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("video", options={"mapping": {"id": "id"}})
     */
    public function removeVideo(Trick $trick, Video $video)
    {
        $trick->removeVideo($video);

        $this->trickRepository->save($trick);

        $this->addFlash('success', 'video.trick.success.deletion');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trick->getSlug(),
        ]);
    }
}
