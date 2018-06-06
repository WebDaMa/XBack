<?php

namespace App\Repository;

use App\Entity\ActivityGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityGroup[]    findAll()
 * @method ActivityGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityGroup::class);
    }

    public function findAllRaw()
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id', 'name')
            ->from('activity_group');

        return $qb->execute()->fetchAll();
    }
}
