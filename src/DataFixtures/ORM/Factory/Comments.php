<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Factory;

use App\Model\DTO\Comment\CreateCommentDTO;
use App\Model\Entity\Comment;

class Comments
{
    public static function create(array $arguments): Comment
    {
        $createCommentDTO = new CreateCommentDTO();

        $createCommentDTO->setContent($arguments['content']);

        return Comment::create($createCommentDTO,  $arguments['trick'], $arguments['user']);
    }
}
