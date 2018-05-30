<?php

namespace App\Repository;

use App\Entity\Guide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GuideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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

    public function getAllByGuideShort($guideShort) {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id')
            ->from('guide')
            ->where('guide_short = :guide_short')
            ->setParameter('guide_short', $guideShort);

        return $qb->execute()->fetch();
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
            ->select('g.*')
            ->from('planning', 'p')
            ->innerJoin('p', 'guide', 'g', 'p.guide_id = g.id')
            ->innerJoin('p', 'groep', 'gr', 'p.group_id = gr.id')
            ->where('WEEK(p.date) = WEEK(:date)')
            ->andWhere('gr.location_id = :locationId')
            ->groupBy('g.id')
            ->setParameter('date', $date)
            ->setParameter('locationId', $locationId);

        return $qb->execute()->fetchAll();
    }


}
