<?php

namespace App\Repository;

use App\Entity\ProgramType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProgramTypeRepository extends CodeBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgramType::class);
    }
}
