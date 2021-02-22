<?php

namespace App\Repository;

use App\Entity\GroupType;
use Doctrine\Persistence\ManagerRegistry;

class GroupTypeRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupType::class);
    }

    public function getAllByPeriodAndLocation($date, $locationId) {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        //SELECT g.* FROM planning p INNER JOIN guide g ON p.`guide_id` = g.id
        //INNER JOIN groep gr ON p.`group_id` = gr.id
        //WHERE WEEK(p.date) = WEEK('2017-07-25')
        //AND gr.location_id = 1
        //GROUP BY g.id
        $qb
            ->select('g.id AS id, g.guide_short AS guideShort, g.guide_first_name AS guideFirstName, 
            g.guide_last_name AS guideLastName')
            ->from('planning', 'p')
            ->innerJoin('p', 'guide', 'g', 'p.guide_id = g.id')
            ->innerJoin('p', 'groep', 'gr', 'p.group_id = gr.id')
            ->where('WEEK(p.date) = WEEK(:date)')
            ->andWhere('YEAR(p.date) = YEAR(:date)')
            ->andWhere('gr.location_id = :locationId')
            ->groupBy('g.id')
            ->setParameter('date', $date)
            ->setParameter('locationId', $locationId);

        return $qb->execute()->fetchAllAssociative();
    }
}
