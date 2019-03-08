<?php

namespace App\Repository;

use App\Model\Entity\Trick;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrickRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function findAllSortAndPaginate(string $page, int $limit)
    {
        $queryBuilder = $this->createQueryBuilder('trick')
            ->orderBy('trick.createdAt', 'DESC');

        $query = $queryBuilder->getQuery();

        $offset = ($page - 1) * $limit;

        $query->setFirstResult($offset)->setMaxResults($limit);

        $paginator = new Paginator($query);

        if (($paginator->count() <= $offset) && $page != 1) {
            throw new NotFoundHttpException();
        }

        return $paginator;
    }
}
