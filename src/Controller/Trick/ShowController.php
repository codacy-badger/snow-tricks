<?php

namespace App\Controller\Trick;

use App\Form\Comment\CreateCommentType;
use App\Model\DTO\Comment\CreateCommentDTO;
use App\Model\Entity\Trick;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    const NUMBER_OF_COMMENTS_PER_LOAD = 2;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/trick/{slug}", name="trick_show")
     */
    public function show(Request $request, Trick $trick): Response
    {
        $createCommentDTO = new CreateCommentDTO();

        $commentForm = $this->createForm(CreateCommentType::class, $createCommentDTO, [
            'action' => $this->generateUrl('comment_create', ['slug' => $trick->getSlug()]),
        ]);

        $commentForm->handleRequest($request);

        $comments = $this->commentRepository->findByTrickSortAndPaginate(
            $trick->getId(),
            1,
            self::NUMBER_OF_COMMENTS_PER_LOAD
        );

        $nbPages = (int) (ceil($comments->count() / self::NUMBER_OF_COMMENTS_PER_LOAD));

        return $this->render('trick/show.html.twig', [
            'commentForm' => $commentForm->createView(),
            'trick' => $trick,
            'comments' => $comments,
            'nbPages' => $nbPages,
        ]);
    }
}
