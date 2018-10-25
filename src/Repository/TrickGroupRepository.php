<?php

namespace App\Repository;

use App\Model\Entity\TrickGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrickGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickGroup[]    findAll()
 * @method TrickGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickGroupRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickGroup::class);
    }

//    /**
//     * @return TrickGroup[] Returns an array of TrickGroup objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrickGroup
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
