<?php

namespace App\Repository;

use App\Entity\InsuranceType;
use Doctrine\Persistence\ManagerRegistry;

class InsuranceTypeRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsuranceType::class);
    }
}