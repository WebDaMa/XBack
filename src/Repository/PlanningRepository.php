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

    public function findByPlanningIdAndDate($planningId, $date) {
        return $this->createQueryBuilder('e')
            ->where('e.planningId = :planningId AND e.date = :date')
            ->setParameters(['planningId' => $planningId, 'date'=> $date])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}
