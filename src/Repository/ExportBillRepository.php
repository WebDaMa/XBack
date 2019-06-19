<?php

namespace App\Repository;

use App\Entity\ExportBill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExportBill|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExportBill|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExportBill[]    findAll()
 * @method ExportBill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExportBillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExportBill::class);
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
