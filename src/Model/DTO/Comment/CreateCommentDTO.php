<?php

namespace App\Model\DTO\Comment;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCommentDTO
{
    /**
     * @var string
     *
     * @Assert\Length(min=5);
     */
    private $content;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
