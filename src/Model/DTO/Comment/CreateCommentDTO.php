<?php

namespace App\Model\DTO\Comment;


class CreateCommentDTO
{
    /**
     * @var string
     *
     * @Assert\Length(min=5);
     */
    private $content;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

}
