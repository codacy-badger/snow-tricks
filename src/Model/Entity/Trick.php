<?php

namespace App\Model\Entity;

use App\Model\DTO\Trick\CreateTrickDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(unique=true)
     * @Assert\Length(min = 3)
     */
    private $name;

    /**
     * @ORM\Column(unique=true)
     * @Assert\Length(min = 3)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\TrickGroup", inversedBy="tricks")
     */
    private $trickGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Entity\Message", mappedBy="trick", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Entity\Photo", mappedBy="trick", orphanRemoval=true, cascade={"persist"})
     */
    private $photos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Entity\Video", inversedBy="tricks")
     */
    private $video;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->video = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message)
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setTrick($this);
        }

        return $this;
    }

    public function removeMessage(Message $message)
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getTrick() === $this) {
                $message->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): void
    {
        if ($this->photos->contains($photo)) {
            return;
        }

        $photo->setTrick($this);

        $this->photos->add($photo);
    }

    public function removePhoto(Photo $photo): void
    {
        if (!$this->photos->contains($photo)) {
            return;
        }

        $this->photos->removeElement($photo);

        // set the owning side to null (unless already changed)
        if ($photo->getTrick() === $this) {
            $photo->setTrick(null);
        }
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video)
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
        }
    }

    public function removeVideo(Video $video)
    {
        if ($this->video->contains($video)) {
            $this->video->removeElement($video);
        }
    }

    public static function create(CreateTrickDTO $createTrickDTO, string $trickSlug): Trick
    {
        $trick = new self();

        $trick->name = $createTrickDTO->getName();
        $trick->description = $createTrickDTO->getDescription();
        $trick->trickGroup = $createTrickDTO->getTrickGroup();
        $trick->createdAt = new \DateTime('now');
        $trick->updatedAt = new \DateTime('now');
        $trick->user = $createTrickDTO->getUser();
        $trick->slug = $trickSlug;

        return $trick;
    }

    public static function modify(CreateTrickDTO $createTrickDTO): Trick
    {
        $trick = new self();

        $trick->name = $createTrickDTO->getName();
        $trick->description = $createTrickDTO->getDescription();
        $trick->trickGroup = $createTrickDTO->getTrickGroup();
        $trick->updatedAt = new \DateTime('now');

        return $trick;
    }


}
