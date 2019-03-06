<?php

namespace App\Model\DTO\User;

use App\Model\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPassUserDTO
{
    /**
     * @var string|null
     *
     * @Assert\Email();
     */
    private $email;

    /**
     * @var string|null
     *
     * @Assert\Length(min=6)
     */
    private $plainPassword;

    /**
     * @var string|null
     */
    private $confirmationToken;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
