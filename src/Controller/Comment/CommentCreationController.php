<?php

namespace App\Controller\Comment;

use App\Form\Comment\CreateCommentType;
use App\Model\DTO\Comment\CreateCommentDTO;
use App\Model\Entity\Comment;
use App\Model\Entity\Trick;
use App\Model\Entity\User;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CommentCreationController extends AbstractController
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/trick/{slug}/comment/create", name="create_comment")
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, Trick $trick)
    {
        $user = $this->getUser();

        $createCommentDTO = new CreateCommentDTO();

        $commentForm = $this->createForm(CreateCommentType::class, $createCommentDTO);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = Comment::create($createCommentDTO, $trick, $user);

            $this->commentRepository->save($comment);

            $this->addFlash('success', 'comment.creation.success');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        $this->addFlash('success', 'comment.creation.fail');

        return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
    }
}
