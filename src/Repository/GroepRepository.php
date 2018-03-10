<?php

namespace App\Repository;

use App\Entity\Groep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GroepRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Groep::class);
    }

    public function findByGroupIdAndPeriodId($groupId, $periodId) {
        return $this->createQueryBuilder('e')
            ->where('e.groupId = :groupId AND e.periodId = :periodId')
            ->setParameters(['groupId' => $groupId, 'periodId'=> $periodId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}