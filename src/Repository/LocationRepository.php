<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Persistence\ManagerRegistry;

class LocationRepository extends CodeBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }


    public function findAllRaw()
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id', 'code')
            ->from('location');

        return $qb->execute()->fetchAllAssociative();
    }

    public function findAllAsChoicesForForm()
    {
        $choices = [];
        $choices['Alle locaties'] = null;
        $locations = $this->findAllRaw();

        foreach ($locations as $location) {
            $choices[$location['code']] = $this->find($location['id']);
        }

        return $choices;
    }

}