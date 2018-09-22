<?php

namespace App\Repository;

use App\Entity\Planning;
use App\Logic\Calculations;
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

    public function findByGuideIdAndDate($guideId, $date): array {
        return $this->createQueryBuilder('e')
            ->where('(e.guide = :guideId OR e.cag1 = :guideId OR e.cag2 = :guideId) AND e.date = :date')
            ->setParameters(['guideId' => $guideId, 'date'=> $date])
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPlanningIdAndDateAndGroepId($planningId, \DateTime $date, $groepId){
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $date = $date->format('Y-m-d');

        return $qb
            ->select("p.id")
            ->from("planning", "p")
            ->innerJoin("p", "groep", "g", "p.group_id = g.id")
            ->where('p.planning_id = :planningId AND p.date = :date AND g.group_id = :groepId')
            ->setParameters(['planningId' => $planningId, 'date'=> $date, 'groepId' => $groepId])
            ->execute()
            ->fetchColumn(0)
            ;
    }

    public function findByLocationIdAndDate($locationId, \DateTime $date){
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $date = $date->format('Y-m-d');

        return $qb
            ->select("p.id", "g.name AS groepName", "p.activity", "p.guide_id AS guideId",
                "p.cag1_id AS cag1Id", "p.cag2_id AS cag2Id", "p.transport", "p.date")
            ->from("planning", "p")
            ->innerJoin("p", "groep", "g", "p.group_id = g.id")
            ->where('g.location_id = :locationId AND p.date = :date')
            ->setParameters(['locationId' => $locationId, 'date'=> $date])
            ->execute()
            ->fetchAll()
            ;
    }

    public function findByGuideIdAndLocationIdAndDate($guideId, $locationId, \DateTime $date) {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $date = $date->format('Y-m-d');
        $lastSaturday = Calculations::getLastSaturdayFromDate($date);
        $nextSaturday = Calculations::getNextSaturdayFromDate($date);

        return $qb
            ->select("p.id", "g.name AS groepName", "p.activity", "p.guide_id AS guideId",
                "p.cag1_id AS cag1Id", "p.cag2_id AS cag2Id", "p.transport", "p.date")
            ->from("planning", "p")
            ->innerJoin("p", "groep", "g", "p.group_id = g.id")
            ->where('g.location_id = :locationId AND (p.date BETWEEN :lastSaturday and :nextSaturday)')
            ->andWhere('(p.guide_id = :guideId OR p.cag1_id = :guideId OR p.cag2_id = :guideId)')
            ->orderBy("p.date", "ASC")
            ->setParameters(['locationId' => $locationId, 'guideId' => $guideId, 'lastSaturday'=> $lastSaturday, 'nextSaturday' => $nextSaturday])
            ->execute()
            ->fetchAll()
            ;
    }
}
