<?php

namespace App\Repository;

use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Planning::class);
    }

    public function findByPlanningIdAndDate($planningId, $date): ?Planning {
        return $this->createQueryBuilder('e')
            ->where('e.planningId = :planningId AND e.date = :date')
            ->setParameters(['planningId' => $planningId, 'date'=> $date])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function findByPlanningIdAndDateAndGroepId($planningId, $date, $groepId): ?Planning {
        return $this->createQueryBuilder('e')
            ->join('e.group','gr')
            ->where('e.planningId = :planningId AND e.date = :date AND gr.id = :groepId')
            ->setParameters(['planningId' => $planningId, 'date'=> $date, 'groepId' => $groepId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}
