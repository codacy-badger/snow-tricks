<?php

namespace App\Controller\Trick;

use App\Form\Comment\CreateCommentType;
use App\Model\DTO\Comment\CreateCommentDTO;
use App\Model\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/trick/show/{slug}", name="trick_show")
     */
    public function show(Request $request, Trick $trick): Response
    {
        $createCommentDTO = new CreateCommentDTO();

        $commentForm = $this->createForm(CreateCommentType::class, $createCommentDTO, [
            'action' => $this->generateUrl('comment_create', ['slug' => $trick->getSlug()]),
        ]);

        $commentForm->handleRequest($request);

        return $this->render('trick/show.html.twig', [
            'commentForm' => $commentForm->createView(),
            'trick' => $trick,
        ]);
    }
}
