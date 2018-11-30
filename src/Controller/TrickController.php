<?php

namespace App\Controller;

use App\Form\Trick\CreateTrickType;
use App\Form\Trick\EditTrickType;
use App\Form\Trick\TrickModificationFormType;
use App\IO\EmbedVideo\TrickVideoCategorizer;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\DTO\Trick\ModifyTrickDTO;
use App\Model\Entity\Photo;
use App\Model\Entity\Trick;
use App\Form\Trick\TrickCreationFormType;
use App\Model\Entity\Video;
use App\Repository\PhotoRepository;
use App\Repository\TrickGroupRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Utils\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @var TrickVideoCategorizer
     */
    private $videoCategorizer;
    /**
     * @var VideoRepository
     */
    private $videoRepository;

    public function __construct(
        TrickRepository $trickRepository,
        UserRepository $userRepository,
        TrickGroupRepository $trickGroupRepository,
        PhotoRepository $photoRepository,
        TrickPhotoUploader $trickPhotoUploader,
        VideoRepository $videoRepository,
        Slugger $slugger,
        TrickVideoCategorizer $videoCategorizer
    ) {
        $this->trickRepository = $trickRepository;
        $this->userRepository = $userRepository;
        $this->trickGroupRepository = $trickGroupRepository;
        $this->slugger = $slugger;
        $this->photoRepository = $photoRepository;
        $this->trickPhotoUploader = $trickPhotoUploader;
        $this->videoCategorizer = $videoCategorizer;
        $this->videoRepository = $videoRepository;
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

            // to do: ajouter un service pour préparer un tableau de video, vérifier qu'elles n'existent pas
            // boucler sur la propriété video de mon dto et créer a la volé les entités video à partir des AddVideoLinkDTO
            // ajouter un 3e arguments dans la méthode create (arrayCollection ou array de video)

            $videosCollection = new ArrayCollection();

            foreach($createTrickDTO->getVideos() as $addVideoLinkDTO)
            {
                $platform = $this->videoCategorizer->getPlatformCode($addVideoLinkDTO)[0];
                $code = $this->videoCategorizer->getPlatformCode($addVideoLinkDTO)[1];

                if(!$video = $this->videoRepository->findOneBy(['videoCode' => $code])){

                    $video = Video::create($code, $platform);

                    $this->videoRepository->save($video);
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

            $this->trickRepository->save($trick);

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
     * @Route("/video/delete/{slug}/{id}", name="video_delete")
     */
    public function removeVideo(Trick $trick, Video $video)
    {
        $trick->removeVideo($video);

        $this->trickRepository->save($trick);

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trick->getSlug(),
        ]);
    }
}
