<?php

namespace App\Repository;

use App\Entity\ProgramType;
use Doctrine\Persistence\ManagerRegistry;

class ProgramTypeRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramType::class);
    }
}
