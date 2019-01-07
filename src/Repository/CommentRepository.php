<?php

namespace App\Repository;

use App\Model\Entity\Comment;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CommentRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }
}
