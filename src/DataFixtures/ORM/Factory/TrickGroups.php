<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Factory;


use App\Model\Entity\TrickGroup;

class TrickGroups
{
    public static function create(array $arguments): TrickGroup
    {
        return new TrickGroup($arguments['name'], $arguments['description']);
    }
}
