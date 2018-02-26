<?php

namespace App\Repository;

use App\Entity\SuitSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SuitSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuitSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuitSize[]    findAll()
 * @method SuitSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuitSizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SuitSize::class);
    }

    public function findByName($name) {
        return $this->createQueryBuilder('e')
            ->where('e.name = :name')
            ->setParameter('name',$name)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}
