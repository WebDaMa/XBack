<?php

namespace App\Repository;

use App\Entity\Guide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GuideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Guide::class);
    }

    public function findByGuideShort($guideShort) : ?Guide {
        return $this->createQueryBuilder('e')
            ->where('e.guideShort = :guideShort')->setParameter('guideShort', $guideShort)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function getIdByGuideShort($guideShort) {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id')
            ->from('guide')
            ->where('guide_short = :guide_short')
            ->setParameter('guide_short', $guideShort);

        return $qb->execute()->fetch();
    }

}
