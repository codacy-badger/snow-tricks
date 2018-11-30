<?php

namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(unique=true)
     */
    private $videoCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column()
     * @Assert\Choice({"youtube", "vimeo", "dailymotion"})
     */
    private $platform;

    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Entity\Trick", mappedBy="video")
     */
    private $tricks;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoCode(): ?string
    {
        return $this->videoCode;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }


    public function setPlatform(string $platform)
    {
        $this->platform = $platform;
    }

    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick)
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->addVideo($this);
        }
    }

    public function removeTrick(Trick $trick)
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            $trick->removeVideo($this);
        }
    }

    public static function create(string $platform, string $code): Video
    {
        $video = new self();

        $video->videoCode = $code;
        $video->platform = $platform;
        $video->createdAt = new \DateTime('now');

        return $video;
    }
}
