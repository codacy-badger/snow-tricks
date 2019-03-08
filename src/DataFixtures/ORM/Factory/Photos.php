<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Factory;

use App\Model\Entity\Photo;

class Photos
{
    public static function create(array $arguments): Photo
    {
        return Photo::create($arguments['filename'], $arguments['trick']);
    }
}
