<?php

namespace App\Repository;

use App\Entity\Guide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GuideRepository extends CodeBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Guide::class);
    }
}
