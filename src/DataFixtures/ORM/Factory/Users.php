<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Factory;

use App\Model\DTO\User\CreateUserDTO;
use App\Model\Entity\User;

class Users
{
    public static function create(array $arguments): User
    {
        $createUserDTO = new CreateUserDTO();

        $createUserDTO->setFirstname($arguments['firstname']);
        $createUserDTO->setLastname($arguments['lastname']);
        $createUserDTO->setEmail((string) $arguments['email']);
        $createUserDTO->setPlainPassword($arguments['plain_password']);

        return User::create($createUserDTO);
    }
}
