<?php

namespace App\Model\DTO\Trick;

use App\Model\Entity\TrickGroup;
use App\Model\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTrickDTO
{
    /**
     * @var string
     *
     * @Assert\Length(min=3);
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Length(min=20)
     */
    private $description;

    /**
     * @var TrickGroup
     */
    private $trickGroup;

    /**
     * @var array
     */
    private $photos;

    /**
     * @var string
     */
    private $videos;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return TrickGroup
     */
    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    /**
     * @param TrickGroup $trickGroup
     */
    public function setTrickGroup(?TrickGroup $trickGroup): void
    {
        $this->trickGroup = $trickGroup;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    /**
     * @return string
     */
    public function getVideos(): ?string
    {
        return $this->videos;
    }

    /**
     * @param string $videos
     */
    public function setVideos(string $videos): void
    {
        $this->videos = $videos;
    }
}
