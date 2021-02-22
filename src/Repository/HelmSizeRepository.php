<?php

namespace App\Repository;

use App\Entity\HelmSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HelmSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method HelmSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method HelmSize[]    findAll()
 * @method HelmSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HelmSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HelmSize::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('h')
            ->where('h.something = :value')->setParameter('value', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
