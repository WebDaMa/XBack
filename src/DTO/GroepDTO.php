<?php


namespace App\DTO;


use App\Entity\Groep;
use App\Repository\AgencyRepository;
use App\Repository\LocationRepository;

class GroepDTO {

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var AgencyRepository
     */
    private $agencyRepository;

    /**
     * GroepDTO constructor.
     * @param LocationRepository $locationRepository
     * @param AgencyRepository $agencyRepository
     */
    public function __construct(LocationRepository $locationRepository, AgencyRepository $agencyRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->agencyRepository = $agencyRepository;
    }


    public function importGroep(array $row, ?Groep $updateGroep = null): Groep
    {
        if (is_null($updateGroep))
        {
            $updateGroep = new Groep();
        }

        $updateGroep->setGroupIndex($row[0]);
        $updateGroep->setName($row[1]);
        $updateGroep->setPeriodId($row[2]);

        $location = $this->locationRepository->findByCode($row[3]);
        if ($location)
        {
            $updateGroep->setLocation($location);
        }

        $updateGroep->setGroupId($row[4]);

        $agency = $this->agencyRepository->findByCode($row[5]);
        if ($agency)
        {
            $updateGroep->setAgency($agency);
        }

        return $updateGroep;
    }
}