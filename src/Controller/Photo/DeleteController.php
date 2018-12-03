<?php

namespace App\Controller\Photo;

use App\Model\Entity\Photo;
use App\Repository\PhotoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @var PhotoRepository
     */
    private $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/photo/delete/{id}", name="photo_delete")
     */
    public function delete(Photo $photo): Response
    {
        $trickSlug = $photo->getTrick()->getSlug();

        $this->photoRepository->remove($photo);

        $this->addFlash('success', 'photo.success.deletion');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trickSlug,
        ]);
    }
}
