<?php

namespace App\Model\Entity;

use App\Model\ValueObject\VideoMeta;
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
     * @ORM\ManyToMany(targetEntity="App\Model\Entity\Trick", mappedBy="videos")
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

    public function setVideoCode($videoCode): void
    {
        $this->videoCode = $videoCode;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getPlatform()
    {
        return $this->platform;
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

    public static function create(VideoMeta $videoMeta): Video
    {
        $video = new self();

        $video->videoCode = $videoMeta->getCode();
        $video->platform = $videoMeta->getPlatform();
        $video->createdAt = new \DateTime('now');

        return $video;
    }
}
