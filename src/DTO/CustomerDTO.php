<?php


namespace App\DTO;


use App\Entity\Customer;
use App\Repository\AgencyRepository;
use App\Repository\AllInTypeRepository;
use App\Repository\CustomerRepository;
use App\Repository\GroepRepository;
use App\Repository\GroupTypeRepository;
use App\Repository\InsuranceTypeRepository;
use App\Repository\LocationRepository;
use App\Repository\LodgingTypeRepository;
use App\Repository\ProgramTypeRepository;
use App\Repository\SuitSizeRepository;
use App\Repository\TravelTypeRepository;
use App\Utils\Calculations;

class CustomerDTO {

    /**
     * @var SuitSizeRepository
     */
    private $suitSizeRepository;

    /**
     * @var AgencyRepository
     */
    private $agencyRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var ProgramTypeRepository
     */
    private $programTypeRepository;

    /**
     * @var LodgingTypeRepository
     */
    private $lodgingTypeRepository;

    /**
     * @var AllInTypeRepository
     */
    private $allInTypeRepository;

    /**
     * @var InsuranceTypeRepository
     */
    private $insuranceTypeRepository;

    /**
     * @var TravelTypeRepository
     */
    private $travelTypeRepository;

    /**
     * @var GroupTypeRepository
     */
    private $groupTypeRepository;

    /**
     * @var GroepRepository
     */
    private $groepRepository;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerDTO constructor.
     * @param SuitSizeRepository $suitSizeRepository
     * @param AgencyRepository $agencyRepository
     * @param LocationRepository $locationRepository
     * @param ProgramTypeRepository $programTypeRepository
     * @param LodgingTypeRepository $lodgingTypeRepository
     * @param AllInTypeRepository $allInTypeRepository
     * @param InsuranceTypeRepository $insuranceTypeRepository
     * @param TravelTypeRepository $travelTypeRepository
     * @param GroupTypeRepository $groupTypeRepository
     * @param GroepRepository $groepRepository
     * @param CustomerRepository $customerRepository
     */
    public function __construct(SuitSizeRepository $suitSizeRepository, AgencyRepository $agencyRepository, LocationRepository $locationRepository, ProgramTypeRepository $programTypeRepository, LodgingTypeRepository $lodgingTypeRepository, AllInTypeRepository $allInTypeRepository, InsuranceTypeRepository $insuranceTypeRepository, TravelTypeRepository $travelTypeRepository, GroupTypeRepository $groupTypeRepository, GroepRepository $groepRepository, CustomerRepository $customerRepository)
    {
        $this->suitSizeRepository = $suitSizeRepository;
        $this->agencyRepository = $agencyRepository;
        $this->locationRepository = $locationRepository;
        $this->programTypeRepository = $programTypeRepository;
        $this->lodgingTypeRepository = $lodgingTypeRepository;
        $this->allInTypeRepository = $allInTypeRepository;
        $this->insuranceTypeRepository = $insuranceTypeRepository;
        $this->travelTypeRepository = $travelTypeRepository;
        $this->groupTypeRepository = $groupTypeRepository;
        $this->groepRepository = $groepRepository;
        $this->customerRepository = $customerRepository;
    }

    public function importCustomer(array $row, ?Customer $updateCustomer = null): Customer
    {
        if (is_null($updateCustomer))
        {
            $updateCustomer = new Customer();
        }

        $updateCustomer->setCustomerId($row[0]);
        $updateCustomer->setFileId($row[1]);
        $updateCustomer->setPeriodId($row[3]);
        $updateCustomer->setBookerId($row[4]);
        $updateCustomer->setBooker($row[5]);
        $updateCustomer->setLastName($row[6]);
        $updateCustomer->setFirstName($row[7]);
        $updateCustomer->setBirthdate(Calculations::convertExcelDateToDateTime($row[8]));
        $updateCustomer->setEmail($row[9]);
        $updateCustomer->setGsm($row[10]);
        $updateCustomer->setNationalRegisterNumber($row[11]);
        $updateCustomer->setExpireDate(Calculations::convertExcelDateToDateTime($row[12]));

        $size = $this->suitSizeRepository->findBySizeId($row[13]);
        if ($size)
        {
            $updateCustomer->setSize($size);
        }

        $updateCustomer->setSizeInfo($row[14]);
        $updateCustomer->setNameShortage($row[15]);
        $updateCustomer->setEmergencyNumber($row[16]);
        $updateCustomer->setLicensePlate($row[17]);

        $updateCustomer->setTypePerson($row[18]);

        $updateCustomer->setInfoCustomer($row[19]);
        $updateCustomer->setInfoFile($row[20]);

        $agency = $this->agencyRepository->findByCode($row[21]);
        if ($agency)
        {
            $updateCustomer->setAgency($agency);
        }

        $location = $this->locationRepository->findByCode($row[22]);
        if ($location)
        {
            $updateCustomer->setLocation($location);
        }

        $updateCustomer->setStartDay(Calculations::convertExcelDateToDateTime($row[23]));
        $updateCustomer->setEndDay(Calculations::convertExcelDateToDateTime($row[24]));

        $program = $this->programTypeRepository->findByCode($row[25]);
        if ($program)
        {
            $updateCustomer->setProgramType($program);
        }

        $lodging = $this->lodgingTypeRepository->findByCode($row[26]);
        if ($lodging)
        {
            $updateCustomer->setLodgingType($lodging);
        }

        $allIn = $this->allInTypeRepository->findByCode($row[27]);
        if ($allIn)
        {
            $updateCustomer->setAllInType($allIn);
        }

        $insuranceType = $this->insuranceTypeRepository->findByCode($row[28]);
        if ($insuranceType)
        {
            $updateCustomer->setInsuranceType($insuranceType);
        }

        $travelGo = $this->travelTypeRepository->findByCode($row[29]);
        if ($travelGo)
        {
            $updateCustomer->setTravelGoType($travelGo);
        }

        $updateCustomer->setTravelGoDate(Calculations::convertExcelDateToDateTime($row[30]));

        $travelBack = $this->travelTypeRepository->findByCode($row[31]);
        if ($travelBack)
        {
            $updateCustomer->setTravelBackType($travelBack);
        }

        $updateCustomer->setTravelBackDate(Calculations::convertExcelDateToDateTime($row[32]));

        $updateCustomer->setBoardingPoint($row[33]);

        $updateCustomer->setActivityOption($row[34]);

        $updateCustomer->setGroupName($row[35]);

        $groupType = $this->groupTypeRepository->findByCode($row[36]);
        if ($groupType)
        {
            $updateCustomer->setGroupPreference($groupType);
        }

        $updateCustomer->setLodgingLayout($row[37]);


        $group = $this->groepRepository->findByGroepIdAndPeriodId($row[38], $updateCustomer->getPeriodId());
        if ($group)
        {
            $updateCustomer->setGroupLayout($group);
        }

        $updateCustomer->setBookerPayed(Calculations::getStringBool($row[39]));

        $updateCustomer->setPayer($this->customerRepository->findByCustomerId($row[40]));

        $updateCustomer->setIsCamper(Calculations::getStringBool($row[41]));

        $updateCustomer->setPayed(Calculations::getStringBool($row[42]));

        $updateCustomer->setCheckedIn(Calculations::getStringBool($row[43]));

        $updateCustomer->setTotalExclInsurance(is_float($row[44]) ? $row[44] : 0);

        $updateCustomer->setInsuranceValue($row[45]);

        return $updateCustomer;
    }
}