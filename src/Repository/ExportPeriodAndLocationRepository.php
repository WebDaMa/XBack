<?php

namespace App\Repository;

use App\Entity\ExportPeriodAndLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExportPeriodAndLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExportPeriodAndLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExportPeriodAndLocation[]    findAll()
 * @method ExportPeriodAndLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExportPeriodAndLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExportPeriodAndLocation::class);
    }

    // /**
    //  * @return ExportBill[] Returns an array of ExportBill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExportBill
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
