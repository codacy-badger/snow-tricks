<?php

namespace App\Repository;

use App\Model\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TrickGroupRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickGroup::class);
    }
}
