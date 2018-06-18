<?php

namespace App\Repository;

use App\Entity\TravelType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TravelTypeRepository extends CodeBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TravelType::class);
    }

    public function getAllBusTypes ():? array {
        return $this->createQueryBuilder('t')
            ->where("t.transportType = 'bus'")
            ->getQuery()
            ->getResult()
            ;
    }
}