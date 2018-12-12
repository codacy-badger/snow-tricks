<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Factory;

use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\Entity\Trick;
use App\Utils\Slugger;

class Tricks
{
    public static function create(array $arguments): Trick
    {
        $createTrickDTO = new CreateTrickDTO($arguments['user']);

        $createTrickDTO->setName($arguments['name']);
        $createTrickDTO->setDescription($arguments['description']);
        $createTrickDTO->setTrickGroup($arguments['trickgroup']);
        $slug = Slugger::slugify($arguments['name']);

        return Trick::create($createTrickDTO, $slug);
    }
}
