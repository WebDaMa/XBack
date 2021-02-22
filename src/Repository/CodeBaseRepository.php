<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CodeBaseRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry, $entityClass = null)
    {
        parent::__construct($registry, $entityClass);
    }

    public function findByCode($code) {

        return $this->createQueryBuilder('e')
            ->where('e.code = :code')->setParameter('code', $code)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }
}
