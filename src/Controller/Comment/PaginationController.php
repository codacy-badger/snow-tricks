<?php

namespace App\Controller\Comment;


use App\Model\Entity\Trick;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PaginationController extends AbstractController
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
     * @Route("/trick/{slug}/comment/pagination", name="comment_pagination")
     */
    public function paginate(Request $request, Trick $trick): Response
    {
        $page = $request->query->get('page');

        $comments = $this->commentRepository->findByTrickSortAndPaginate(
            $trick->getId(),
            $page,
            self::NUMBER_OF_COMMENTS_PER_LOAD
        );

        return $this->render('comments/paginated-comments-list.html.twig', [
            'comments' => $comments,
            'page' => $page,
        ]);

    }
}
