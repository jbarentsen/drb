<?php

namespace DwsBase\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

/**
 * The AbstractRepository provides default implementations of the methods defined
 * in the base repository
 */
abstract class AbstractRepository extends EntityRepository
{
    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * Get all items
     *
     * @return mixed[]
     */
    public function findAll()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from($this->getClassName(), 'u');

        return $qb->getQuery()->getResult();
    }

    /**
     * Get paginator for items
     *
     * @return DoctrinePaginator
     */
    public function findAllPaged()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from($this->getClassName(), 'u');

        return $this->getPaginator($qb->getQuery());
    }

    /**
     * Get paginator for search items
     *
     * @param array $parameters
     * @return Paginator
     */
    public function getPagedSearch($parameters)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from($this->getClassName(), 'u');
        foreach ($parameters as $key => $value) {
            $qb->where(sprintf('u.%s LIKE %s', $key, ':' . $key))
                ->setParameter($key, '%' . $value . '%');
        }

        return $this->getPaginator($qb->getQuery());
    }

    /**
     * Get paginator for query
     *
     * @param Query $query
     * @return DoctrinePaginator
     */
    protected function getPaginator(Query $query)
    {
        return new DoctrinePaginator(new Paginator($query));
    }
}
