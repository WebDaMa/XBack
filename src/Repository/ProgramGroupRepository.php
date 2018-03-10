<?php

namespace App\Repository;

use App\Entity\ProgramGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgramGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramGroup[]    findAll()
 * @method ProgramGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgramGroup::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
