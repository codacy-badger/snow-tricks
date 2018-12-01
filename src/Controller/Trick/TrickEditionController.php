<?php

namespace App\Controller\Trick;

use App\Form\Trick\EditTrickType;
use App\IO\Upload\TrickPhotoUploader;
use App\Model\DTO\Trick\ModifyTrickDTO;
use App\Model\Entity\Trick;
use App\Repository\TrickRepository;
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
     * @var TrickPhotoUploader
     */
    private $trickPhotoUploader;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

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
            $trick = Trick::modify($modifyTrickDTO);

            $trick->updateVideos($modifyTrickDTO->getVideos(), $this->entityManager);

            $trick->updatePhotos($modifyTrickDTO->getPhotos(),$this->trickPhotoUploader);

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
