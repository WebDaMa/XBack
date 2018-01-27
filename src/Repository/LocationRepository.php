<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LocationRepository extends CodeBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Location::class);
    }
}