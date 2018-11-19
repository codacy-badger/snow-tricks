<?php

namespace App\Model\DTO\Trick;

use App\Model\Entity\Trick;
use App\Model\Entity\TrickGroup;
use Symfony\Component\Validator\Constraints as Assert;

class ModifyTrickDTO
{
    private $trick;

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

    public function __construct(Trick $trick)
    {
        $this->trick = $trick;
        $this->name = $trick->getName();
        $this->description = $trick->getDescription();
        $this->trickGroup = $trick->getTrickGroup();
        //$this->photos = $trick->getPhotos();
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

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    /**
     * @return Trick
     */
    public function getTrick(): Trick
    {
        return $this->trick;
    }

    /**
     * @param Trick $trick
     */
    public function setTrick(Trick $trick): void
    {
        $this->trick = $trick;
    }
}
