<?php

namespace App\Repository;

use App\Entity\BeltSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BeltSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method BeltSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method BeltSize[]    findAll()
 * @method BeltSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeltSizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BeltSize::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('b')
            ->where('b.something = :value')->setParameter('value', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
