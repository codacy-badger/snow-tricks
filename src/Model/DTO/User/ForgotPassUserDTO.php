<?php

namespace App\Model\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;

class ForgotPassUserDTO
{
    /**
     * @var string|null
     *
     * @Assert\Email();
     */
    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
