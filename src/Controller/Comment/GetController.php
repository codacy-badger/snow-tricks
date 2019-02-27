<?php

namespace App\Controller\Comment;


use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GetController
{
    const NUMBER_OF_COMMENTS_PER_LOAD = 5;

    /**
     * @var CommentRepository
     */
    private $commentRepository;


    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/comments/getmore", name="comments_get")
     */
    public function get(Request $request): Response
    {
        $trick = $request->query->get('trick');
        $index = $request->query->get('index');

        $comments = $this->commentRepository->findByTrickSortAndPaginate(
            $trick,
            $index,
            self::NUMBER_OF_COMMENTS_PER_LOAD
        );

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($comments));

        return $response;
    }
}
