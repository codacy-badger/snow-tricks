<?php

namespace App\Model\DTO\Trick;

use App\Model\DTO\Video\AddVideoLinkDTO;
use App\Model\Entity\TrickGroup;
use App\Model\Entity\User;
use App\Model\Entity\Video;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection|AddVideoLinkDTO[]
     */
    private $videos;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->videos = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?TrickGroup $trickGroup): void
    {
        $this->trickGroup = $trickGroup;
    }

    public function getUser(): User
    {
        return $this->user;
    }


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

    public function getVideos(): ?ArrayCollection
    {
        return $this->videos;
    }

    public function addVideo(AddVideoLinkDTO $videoLinkDTO): void
    {
        if ($this->videos->contains($videoLinkDTO)) {
            return;
        }

        $this->videos->add($videoLinkDTO);
    }

    public function removeVideo(AddVideoLinkDTO $videoLinkDTO): void
    {
        if (!$this->videos->contains($videoLinkDTO)) {
            return;
        }

        $this->videos->removeElement($videoLinkDTO);
    }

}
