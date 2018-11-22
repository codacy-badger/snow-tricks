<?php

namespace App\Model\DTO\Video;

use Symfony\Component\Validator\Constraints as Assert;

class AddVideoLinkDTO
{
    /**
     * @var string|null
     *
     * @Assert\Url();
     */
    private $link;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }
}
