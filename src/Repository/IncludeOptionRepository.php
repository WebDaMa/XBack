<?php

namespace App\Repository;

use App\Entity\IncludeOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IncludeOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncludeOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncludeOption[]    findAll()
 * @method IncludeOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncludeOptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncludeOption::class);
    }

    // /**
    //  * @return IncludeOption[] Returns an array of IncludeOption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IncludeOption
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
