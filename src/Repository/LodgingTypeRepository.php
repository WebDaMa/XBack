<?php

namespace App\Repository;

use App\Entity\LodgingType;
use Doctrine\Persistence\ManagerRegistry;

class LodgingTypeRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LodgingType::class);
    }
}
