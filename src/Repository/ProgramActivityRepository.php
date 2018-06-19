<?php

namespace App\Repository;

use App\Entity\Activity;
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


    public function findByProgramTypeAndActivity($programTypeId , $activityId) : ?ProgramActivity
    {
        return $this->createQueryBuilder('p')
            ->where('p.programType = :programTypeId')
            ->andWhere("p.activity = :activityId")
            ->setParameters(['programTypeId' => $programTypeId, 'activityId' => $activityId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }
}
