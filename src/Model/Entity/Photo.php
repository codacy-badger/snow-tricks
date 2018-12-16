<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $filename;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private $thumbnail;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Trick", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function isThumbnail()
    {
        return $this->thumbnail;
    }

    public function modifyThumbnailStatus(bool $thumbnailStatus): void
    {
        $this->thumbnail = $thumbnailStatus;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick($trick): void
    {
        $this->trick = $trick;
    }

    public static function create(string $filename, Trick $trick): self
    {
        $photo = new self();

        $photo->filename = $filename;
        $photo->createdAt = new \DateTime('now');
        $photo->trick = $trick;
        $photo->thumbnail = false;

        return $photo;
    }

}
