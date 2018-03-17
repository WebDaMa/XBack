<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findByCustomerId($customerId) {
        return $this->createQueryBuilder('e')
            ->where('e.customerId = :customerId')
            ->setParameters(['customerId' => $customerId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }
}
