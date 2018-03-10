<?php

namespace App\Repository;

use App\Entity\ProgramActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgramActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramActivity[]    findAll()
 * @method ProgramActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgramActivity::class);
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
