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
    public function addOnTop(Photo $photoOnTop): Response
    {
        $trickSlug = $photoOnTop->getTrick()->getSlug();

        $photos = $photoOnTop->getTrick()->getPhotos();

        //Todo: faire une fonction trick->updateThumbnail a la place
        /**
         * @var Photo $photo
         */
        foreach($photos as $photo)
        {
            $photo->setImageOnTop(false);
            $this->entityManager->persist($photo);
        }

        $photoOnTop->setImageOnTop(true);

        $this->entityManager->persist($photoOnTop);
        $this->entityManager->flush();

        $this->addFlash('success', 'photo.success.modification');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trickSlug,
        ]);
    }
}
