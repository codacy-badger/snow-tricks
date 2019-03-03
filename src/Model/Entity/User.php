<?php

namespace App\Model\Entity;

use App\Model\DTO\User\CreateUserDTO;
use App\Model\DTO\User\ResetPassUserDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string The plain password
     */
    private $plainPassword;

    /**
     * @ORM\Column()
     * @Assert\Length(min = 3)
     */
    private $lastname;

    /**
     * @ORM\Column(nullable=true)
     * @Assert\Length(min =3)
     */
    private $firstname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $passwordForgotten = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Entity\Trick", mappedBy="user", orphanRemoval=true)
     */
    private $tricks;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function isPasswordForgotten(): bool
    {
        return $this->passwordForgotten;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): void
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }
    }

    public function removeTrick(Trick $trick): void
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            // set the owning side to null (unless already changed)
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): void
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }
    }

    public function removeComment(Comment $comment): void
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public static function create(CreateUserDTO $userDTO): User
    {
        $user = new self();

        $user->email = $userDTO->getEmail();
        $user->firstname = $userDTO->getFirstname();
        $user->lastname = $userDTO->getLastname();
        $user->plainPassword = $userDTO->getPlainPassword();
        $user->roles = ['ROLE_USER'];
        $user->createdAt = new \DateTime('now');
        $user->enabled = false;
        $user->confirmationToken = $userDTO->getConfirmationToken();

        return $user;
    }

    public static function forgotPass(ResetPassUserDTO $userDTO): User
    {
        $user = $userDTO->getUser();

        $user->updatedAt = new \DateTime('now');
        $user->confirmationToken = $userDTO->getConfirmationToken();
        $user->passwordForgotten = true;

        return $user;
    }

    public static function resetPass(ResetPassUserDTO $userDTO): User
    {
        $user = $userDTO->getUser();

        $user->updatedAt = new \DateTime('now');
        $user->confirmationToken = null;
        $user->passwordForgotten = false;
        $user->plainPassword = $userDTO->getPlainPassword();

        return $user;
    }

    public function confirm(): void
    {
        $this->enabled = true;
        $this->confirmationToken = null;
    }

}
