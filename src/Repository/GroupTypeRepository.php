<?php

namespace App\Repository;

use App\Entity\GroupType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GroupTypeRepository extends CodeBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GroupType::class);
    }
}
