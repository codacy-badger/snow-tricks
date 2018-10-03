<?php

namespace App\Model\DTO\User;

class CreateUserDTO
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
     *
     * @Assert\Length(min=3)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @Assert\Length(min=3)
     */
    private $firstname;

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public static function create(CreateUserDTO $userDTO)
    {


    }
}
