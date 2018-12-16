<?php

namespace App\Controller\Photo;

use App\Model\Entity\Photo;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddOnTopController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/photo/add-on-top/{id}", name="photo_add_on_top")
     */
    public function addOnTop(Photo $photoThumbnail): Response
    {
        $trick = $photoThumbnail->getTrick();

        $trickSlug = $trick->getSlug();

        $trick->updateThumbnail($photoThumbnail);

        $this->entityManager->persist($trick);
        $this->entityManager->flush();

        $this->addFlash('success', 'photo.success.modification');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trickSlug,
        ]);
    }
}
