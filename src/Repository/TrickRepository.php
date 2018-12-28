<?php

namespace App\Repository;

use App\Model\Entity\Trick;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function findAllSortAndPaginate($page, $maxTricksPerPage)
    {
        $qb = $this->createQueryBuilder('trick')
            ->orderBy('trick.createdAt', 'DESC');

        $query = $qb->getQuery();

        $firstResult = ($page - 1) * $maxTricksPerPage;

        $query->setFirstResult($firstResult)->setMaxResults($maxTricksPerPage);

        $paginator = new Paginator($query);

        if (($paginator->count() <= $firstResult) && $page != 1) {
            throw new NotFoundHttpException();
        }

        return $paginator;
    }
}
