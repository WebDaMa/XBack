<?php

namespace App\Repository;

use App\Entity\Guide;
use App\Utils\Extensions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GuideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guide::class);
    }

    public function findByGuideShort($guideShort) : ?Guide {
        return $this->createQueryBuilder('e')
            ->where('e.guideShort = :guideShort')->setParameter('guideShort', $guideShort)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function getIdByGuideShort($guideShort): string {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id')
            ->from('guide')
            ->where('guide_short = :guide_short')
            ->setParameter('guide_short', $guideShort);

        return $qb->execute()->fetchAssociative();
    }

    public function getAllByPeriodAndLocation($period, $locationId): array {
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
            ->where('gr.period_id = :period')
            ->andWhere('gr.location_id = :locationId')
            ->groupBy('g.id')
            ->setParameter('period', $period)
            ->setParameter('locationId', $locationId);

        $guides = $qb->execute()->fetchAllAssociative();

        $qb = $connection->createQueryBuilder();

        // CAG1
        $qb
            ->select('g.id AS id, g.guide_short AS guideShort, g.guide_first_name AS guideFirstName, 
            g.guide_last_name AS guideLastName')
            ->from('planning', 'p')
            ->innerJoin('p', 'guide', 'g', 'p.cag1_id = g.id')
            ->innerJoin('p', 'groep', 'gr', 'p.group_id = gr.id')
            ->where('gr.period_id = :period')
            ->andWhere('gr.location_id = :locationId')
            ->groupBy('g.id')
            ->setParameter('period', $period)
            ->setParameter('locationId', $locationId);

        $cag1s = $qb->execute()->fetchAllAssociative();

        $qb = $connection->createQueryBuilder();

        // CAG2
        $qb
            ->select('g.id AS id, g.guide_short AS guideShort, g.guide_first_name AS guideFirstName, 
        g.guide_last_name AS guideLastName')
            ->from('planning', 'p')
            ->innerJoin('p', 'guide', 'g', 'p.cag2_id = g.id')
            ->innerJoin('p', 'groep', 'gr', 'p.group_id = gr.id')
            ->where('gr.period_id = :period')
            ->andWhere('gr.location_id = :locationId')
            ->groupBy('g.id')
            ->setParameter('period', $period)
            ->setParameter('locationId', $locationId);

        $cag2s = $qb->execute()->fetchAllAssociative();

        //Have unique guides

        $guides = Extensions::unique_multidim_array(array_merge($guides, $cag1s, $cag2s), "id");

        return $guides;
    }


}
