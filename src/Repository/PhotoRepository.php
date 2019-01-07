<?php

namespace App\Repository;

use App\Model\Entity\Photo;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PhotoRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Photo::class);
    }
}
