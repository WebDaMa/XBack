<?php

namespace App\Repository;

use App\Entity\AllInType;
use Doctrine\Persistence\ManagerRegistry;

class AllInTypeRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AllInType::class);
    }
}