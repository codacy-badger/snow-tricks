<?php

namespace App\Model\DTO\Trick;

use App\Model\Entity\Trick;
use App\Model\Entity\TrickGroup;
use App\Model\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class ModifyTrickDTO
{
    private $id;

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
     *
     */
    private $photos;

    /**
     * @var User
     */
    private $user;


    public function __construct(User $user, Trick $trick)
    {
        $this->id = $trick->getId();
        $this->name = $trick->getName();
        $this->description = $trick->getDescription();
        $this->trickGroup = $trick->getTrickGroup();
        //$this->photos = $trick->getPhotos();
        $this->user = $trick->getUser();
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

}
