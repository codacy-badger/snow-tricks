<?php

namespace App\Controller\Trick;

use App\Form\Trick\CreateTrickType;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\Entity\Trick;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickCreationController extends AbstractController
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

            $trick = Trick::create($createTrickDTO, $slug);

            $trick->updateVideos($createTrickDTO->getVideos(), $this->entityManager);

            $trick->updatePhotos($createTrickDTO->getPhotos(), $this->trickPhotoUploader);

            $this->entityManager->persist($trick);

            $this->entityManager->flush();

            $this->addFlash('success', 'trick.success.creation');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/new.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
    }
}
