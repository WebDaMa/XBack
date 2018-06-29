<?php

namespace App\Repository;

use App\Entity\Agency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AgencyRepository extends CodeBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Agency::class);
    }

    public function getAllByPeriodAndLocation($periodId, $locationId): array {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder()
            ->select('a.id, a.code AS name')
            ->from('customer', 'c')
            ->innerJoin("c", "agency", "a", "c.agency_id = a.id")
            ->where("c.period_id = :periodId
            AND c.location_id = :locationId")
            ->groupBy("a.id")
            ->setParameters(['periodId' => $periodId, 'locationId'=> $locationId])
        ;

        return $qb->execute()->fetchAll();
    }
}
