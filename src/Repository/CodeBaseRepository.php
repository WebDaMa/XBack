<?php

namespace App\Repository;

use App\Entity\Agency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CodeBaseRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry, $entityClass = null)
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
