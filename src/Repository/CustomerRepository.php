<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findByCustomerId($customerId): ?Customer
    {
        return $this->createQueryBuilder('e')
            ->where('e.customerId = :customerId')
            ->setParameters(['customerId' => $customerId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function getSuitSizesByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("CONCAT(c.first_name, ' ', c.last_name) AS customer", 's.name AS size', 'c.size_info AS sizeInfo')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getSuitSizeTotalsByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('s.name AS size', 'COUNT(c.size_id) AS total')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->groupBy('s.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getBeltSizeTotalsByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('bs.name AS size', 'COUNT(c.size_id) AS total')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->innerJoin('s', 'belt_size', 'bs', 's.belt_size_id = bs.id')
            ->groupBy('bs.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getHelmetSizeTotalsByCustomerIds(array $customerIds)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('hs.name AS size', 'COUNT(c.size_id) AS total')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->innerJoin('s', 'helm_size', 'hs', 's.helm_size_id = hs.id')
            ->groupBy('hs.id')
            ->add('where', $qb->expr()->in('c.id', $customerIds));

        return $qb->execute()->fetchAll();
    }

    public function getAllByGroepId($groepId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select("c.id", "CONCAT(c.first_name, ' ', c.last_name) AS customer", 's.name AS size', 'c.size_info AS sizeInfo')
            ->from('customer', 'c')
            ->innerJoin('c', 'suit_size', 's', 'c.size_id = s.id')
            ->where("c.group_layout_id = :groepId")
            ->setParameter("groepId", $groepId);

        return $qb->execute()->fetchAll();
    }
}
