<?php

namespace App\Repository;

use App\Entity\TransportType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransportType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransportType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransportType[]    findAll()
 * @method TransportType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportType::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.something = :value')->setParameter('value', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
