<?php

namespace App\Repository;

use App\Entity\Groep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GroepRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groep::class);
    }

    public function findByGroepIdAndPeriodId($groepId, $periodId): ?Groep
    {
        return $this->createQueryBuilder('e')
            ->where('e.groupId = :groupId AND e.periodId = :periodId')
            ->setParameters(['groupId' => $groepId, 'periodId' => $periodId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findByGroepIdAndPeriodIdAndLocationId($groepId, $periodId, $locationId): ?Groep
    {
        return $this->createQueryBuilder('e')
            ->where('e.groupId = :groupId AND e.periodId = :periodId AND e.location = :locationId')
            ->setParameters(['groupId' => $groepId, 'periodId' => $periodId, 'locationId' => $locationId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function getAllByPeriodAndLocation($periodId, $locationId): array
    {
        $connection = $this->_em->getConnection();

        $qb = $connection->createQueryBuilder()
            ->select('g.id, g.name')
            ->from('groep', 'g')
            ->where('g.period_id = :periodId')
            ->setParameter('periodId', $periodId);

        if (!is_null($locationId))
        {
         $qb->andWhere('g.location_id = :locationId')
            ->setParameter("locationId", $locationId);
        }

        return $qb->execute()->fetchAllAssociative();
    }

    public function getAllPeriodIds()
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('DISTINCT g.period_id')
            ->from('groep', 'g');

        return $qb->execute()->fetchAllAssociative();
    }

    public function getAllYears()
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('DISTINCT(LEFT(g.period_id, 2)) AS year')
            ->from('groep', 'g');

        return $qb->execute()->fetchAllAssociative();
    }

    public function getAllPeriodIdsAsChoicesForForm()
    {
        $choices = [];
        $choices['All periods'] = null;
        $periods = $this->getAllPeriodIds();

        foreach ($periods as $period)
        {
            $choices[$period['period_id']] = $period['period_id'];
        }

        return $choices;
    }

    public function getAllYearsAsChoicesForForm()
    {
        $choices = [];
        $choices['All years'] = null;
        $years = $this->getAllYears();

        foreach ($years as $year)
        {
            $choices[$year['year']] = $year['year'];
        }

        return $choices;
    }

}
