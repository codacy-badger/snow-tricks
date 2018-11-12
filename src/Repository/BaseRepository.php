<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function save($entity = null)
    {
        if ($entity) {
            $this->_em->persist($entity);
        }
        $this->_em->flush();
    }

    public function add($entity)
    {
        $this->_em->persist($entity);
    }

    public function remove($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
