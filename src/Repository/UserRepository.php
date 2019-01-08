<?php

namespace App\Repository;

use App\Model\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
}
