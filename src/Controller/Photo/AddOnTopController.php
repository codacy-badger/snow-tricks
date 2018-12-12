<?php

namespace App\Controller\Photo;

use App\Model\Entity\Photo;
use App\Repository\PhotoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddOnTopController extends AbstractController
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
     * @Route("/photo/add-on-top/{id}", name="photo_add_on_top")
     */
    public function addOnTop(Photo $photoOnTop): Response
    {
        $trickSlug = $photoOnTop->getTrick()->getSlug();

        $photos = $photoOnTop->getTrick()->getPhotos();

        /**
         * @var Photo $photo
         */
        foreach($photos as $photo)
        {
            $photo->setImageOnTop(false);
            $this->photoRepository->save($photo);
        }

        $photoOnTop->setImageOnTop(true);

        $this->photoRepository->save($photo);

        $this->addFlash('success', 'photo.success.modification');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trickSlug,
        ]);
    }
}
