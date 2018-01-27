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
}
