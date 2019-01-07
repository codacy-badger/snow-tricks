<?php

namespace App\Repository;

use App\Model\Entity\Video;
use Symfony\Bridge\Doctrine\RegistryInterface;

class VideoRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Video::class);
    }
}
