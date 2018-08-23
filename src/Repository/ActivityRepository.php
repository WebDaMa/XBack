<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function findByName($name)
    {
        $name = strtolower($name);
        return $this->createQueryBuilder('a')
            ->where('a.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    public function findAllByActivityGroupId($activityGroupId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id', 'name')
            ->from('activity')
            ->where("activity_group_id = :activityGroupId")
            ->setParameters(["activityGroupId" => $activityGroupId]);

        return $qb->execute()->fetchAll();
    }

    public function findAllByActivityGroupIdForProgramTypeId($activityGroupId, $programTypeId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('a.id', 'a.name')
            ->from('activity', "a")
            ->innerJoin("a", "program_activity", "pa", "pa.activity_id = a.id")
            ->where("pa.program_type_id = :programTypeId")
            ->andWhere("a.activity_group_id = :activityGroupId")
            ->setParameters(["activityGroupId" => $activityGroupId, "programTypeId" => $programTypeId]);

        return $qb->execute()->fetchAll();
    }

    public function findAllByCustomerId($customerId)
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('ag.name AS type', 'a.name', 'a.price')
            ->from('customers_activities', "ca")
            ->innerJoin("ca", "activity", "a", "ca.activity_id = a.id")
            ->innerJoin("a", "activity_group", "ag", "a.activity_group_id = ag.id")
            ->where("ca.customer_id = :customerId")
            ->setParameters(["customerId" => $customerId]);

        return $qb->execute()->fetchAll();
    }

}
