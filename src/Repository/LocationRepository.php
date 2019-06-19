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


    public function findAllRaw()
    {
        $connection = $this->_em->getConnection();
        $qb = $connection->createQueryBuilder();

        $qb
            ->select('id', 'code')
            ->from('location');

        return $qb->execute()->fetchAll();
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