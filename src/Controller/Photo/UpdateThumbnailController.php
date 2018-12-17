<?php

namespace App\Controller\Photo;

use App\Model\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateThumbnailController extends AbstractController
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
     * @Route("/photo/update-thumbnail/{id}", name="photo_update_thumbnail")
     */
    public function updateThumbnail(Photo $photoThumbnail): Response
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
