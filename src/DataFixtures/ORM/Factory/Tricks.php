<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Factory;

use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\Entity\Trick;

class Tricks
{
    public static function create(array $arguments): Trick
    {
        $createTrickDTO = new CreateTrickDTO();

        $createTrickDTO->setName($arguments['name']);
        $createTrickDTO->setDescription($arguments['description']);
        $createTrickDTO->setTrickGroup($arguments['trickgroup']);

        return Trick::create($createTrickDTO, $arguments['user'], $arguments['slug']);
    }
}
