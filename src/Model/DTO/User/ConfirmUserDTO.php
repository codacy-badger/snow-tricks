<?php

namespace App\Model\DTO\User;

use App\Model\Entity\User;

class ConfirmUserDTO
{
    private $user;

    /**
     * @var string|null
     */
    private $status;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
