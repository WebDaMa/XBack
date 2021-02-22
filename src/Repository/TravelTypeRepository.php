<?php

namespace App\Repository;

use App\Entity\TravelType;
use Doctrine\Persistence\ManagerRegistry;

class TravelTypeRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TravelType::class);
    }

    public function getAllBusTypes ():? array {
        return $this->createQueryBuilder('t')
            ->where("t.transportType = 2")
            ->getQuery()
            ->getResult()
            ;
    }
}