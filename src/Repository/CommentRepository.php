<?php

namespace App\Repository;

use App\Model\Entity\Comment;
use App\Model\Entity\Trick;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findByTrickSortAndPaginate(int $trickID, int $page, int $limit)
    {
        $qb = $this->createQueryBuilder('comment')
            ->andWhere('comment.trick = '.$trickID)
            ->orderBy('comment.created_at', 'DESC');

        $query = $qb->getQuery();

        $offset = ($page - 1) * $limit;

        $query->setFirstResult($offset)->setMaxResults($limit);

        $paginator = new Paginator($query);

        if (($paginator->count() <= $offset) && $page != 1) {
            throw new NotFoundHttpException();
        }

        return $paginator;
    }

}
