<?php

namespace App\Repository;

use App\Entity\ProgramActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgramActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramActivity[]    findAll()
 * @method ProgramActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgramActivity::class);
    }

    public function hasProgramActivityByProgramTypeAndActivity($programTypeId , $activityId) : ?bool
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $pa = $qb
            ->select('pa.id')
            ->from('program_activity', "pa")
            ->where('pa.program_type_id = :programTypeId')
            ->andWhere("pa.activity_id = :activityId")
            ->setParameters(['programTypeId' => $programTypeId, 'activityId' => $activityId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();


        return is_null($pa) ? false : true;
    }
}
