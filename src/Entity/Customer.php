<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $customerId;

    /**
     * @ORM\Column(type="integer")
     */
    private $fileId;

    /**
     * @ORM\Column(type="integer")
     */
    private $periodId;

    /**
     * @ORM\Column(type="integer")
     */
    private $bookerId;

    /**
     * @ORM\Column(type="string")
     */
    private $booker;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $gsm;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nationalRegisterNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expireDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nameShortage;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emergencyNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $licensePlate;

    //TODO: check for relation
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $typePerson;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoCustomer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    /**
     * @ORM\Column(type="string")
     */
    private $location;

    /**
     * @ORM\Column(type="date")
     */
    private $startDay;

    /**
     * @ORM\Column(type="date")
     */
    private $endDay;

    /**
     * @ORM\ManyToOne(targetEntity="ProgramType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $programType;

    /**
     * @ORM\ManyToOne(targetEntity="LodgingType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lodgingType;

    /**
     * @ORM\ManyToOne(targetEntity="AllInType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $allInType;

    /**
     * @ORM\ManyToOne(targetEntity="InsuranceType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $insuranceType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TravelType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $travelGoType;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $travelGoDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TravelType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $travelBackType;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $travelBackDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $boardingPoint;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $activityOption;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $groupName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $groupPreference;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $LodgingLayout;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $groupLayout;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $bookerPayed;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Customer")
     */
    private $payerId;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $isCamper;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $checkedIn;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalExclInsurance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $insuranceValue;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBooker()
    {
        return $this->booker;
    }

    /**
     * @param mixed $booker
     */
    public function setBooker($booker): void
    {
        $this->booker = $booker;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * @param mixed $gsm
     */
    public function setGsm($gsm): void
    {
        $this->gsm = $gsm;
    }

    /**
     * @return mixed
     */
    public function getNationalRegisterNumber()
    {
        return $this->nationalRegisterNumber;
    }

    /**
     * @param mixed $nationalRegisterNumber
     */
    public function setNationalRegisterNumber($nationalRegisterNumber): void
    {
        $this->nationalRegisterNumber = $nationalRegisterNumber;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param mixed $expireDate
     */
    public function setExpireDate($expireDate): void
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getNameShortage()
    {
        return $this->nameShortage;
    }

    /**
     * @param mixed $nameShortage
     */
    public function setNameShortage($nameShortage): void
    {
        $this->nameShortage = $nameShortage;
    }

    /**
     * @return mixed
     */
    public function getEmergencyNumber()
    {
        return $this->emergencyNumber;
    }

    /**
     * @param mixed $emergencyNumber
     */
    public function setEmergencyNumber($emergencyNumber): void
    {
        $this->emergencyNumber = $emergencyNumber;
    }

    /**
     * @return mixed
     */
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }

    /**
     * @param mixed $licensePlate
     */
    public function setLicensePlate($licensePlate): void
    {
        $this->licensePlate = $licensePlate;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return mixed
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * @param mixed $fileId
     */
    public function setFileId($fileId): void
    {
        $this->fileId = $fileId;
    }

    /**
     * @return mixed
     */
    public function getPeriodId()
    {
        return $this->periodId;
    }

    /**
     * @param mixed $periodId
     */
    public function setPeriodId($periodId): void
    {
        $this->periodId = $periodId;
    }

    /**
     * @return mixed
     */
    public function getBookerId()
    {
        return $this->bookerId;
    }

    /**
     * @param mixed $bookerId
     */
    public function setBookerId($bookerId): void
    {
        $this->bookerId = $bookerId;
    }

    /**
     * @return mixed
     */
    public function getTypePerson()
    {
        return $this->typePerson;
    }

    /**
     * @param mixed $typePerson
     */
    public function setTypePerson($typePerson): void
    {
        $this->typePerson = $typePerson;
    }

    /**
     * @return mixed
     */
    public function getInfoCustomer()
    {
        return $this->infoCustomer;
    }

    /**
     * @param mixed $infoCustomer
     */
    public function setInfoCustomer($infoCustomer): void
    {
        $this->infoCustomer = $infoCustomer;
    }

    /**
     * @return mixed
     */
    public function getInfoFile()
    {
        return $this->infoFile;
    }

    /**
     * @param mixed $infoFile
     */
    public function setInfoFile($infoFile): void
    {
        $this->infoFile = $infoFile;
    }

    /**
     * @return mixed
     */
    public function getAgency() : Agency
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency): void
    {
        $this->agency = $agency;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getStartDay()
    {
        return $this->startDay;
    }

    /**
     * @param mixed $startDay
     */
    public function setStartDay($startDay): void
    {
        $this->startDay = $startDay;
    }

    /**
     * @return mixed
     */
    public function getEndDay()
    {
        return $this->endDay;
    }

    /**
     * @param mixed $endDay
     */
    public function setEndDay($endDay): void
    {
        $this->endDay = $endDay;
    }

    /**
     * @return mixed
     */
    public function getProgramType() : ProgramType
    {
        return $this->programType;
    }

    /**
     * @param mixed $programType
     */
    public function setProgramType(ProgramType $programType): void
    {
        $this->programType = $programType;
    }

    /**
     * @return mixed
     */
    public function getLodgingType()
    {
        return $this->lodgingType;
    }

    /**
     * @param mixed $lodgingType
     */
    public function setLodgingType($lodgingType): void
    {
        $this->lodgingType = $lodgingType;
    }

    /**
     * @return mixed
     */
    public function getAllInType()
    {
        return $this->allInType;
    }

    /**
     * @param mixed $allInType
     */
    public function setAllInType($allInType): void
    {
        $this->allInType = $allInType;
    }

    /**
     * @return mixed
     */
    public function getInsuranceType()
    {
        return $this->insuranceType;
    }

    /**
     * @param mixed $insuranceType
     */
    public function setInsuranceType($insuranceType): void
    {
        $this->insuranceType = $insuranceType;
    }

    /**
     * @return mixed
     */
    public function getTravelGoType()
    {
        return $this->travelGoType;
    }

    /**
     * @param mixed $travelGoType
     */
    public function setTravelGoType($travelGoType): void
    {
        $this->travelGoType = $travelGoType;
    }

    /**
     * @return mixed
     */
    public function getTravelGoDate()
    {
        return $this->travelGoDate;
    }

    /**
     * @param mixed $travelGoDate
     */
    public function setTravelGoDate($travelGoDate): void
    {
        $this->travelGoDate = $travelGoDate;
    }

    /**
     * @return mixed
     */
    public function getTravelBackType()
    {
        return $this->travelBackType;
    }

    /**
     * @param mixed $travelBackType
     */
    public function setTravelBackType($travelBackType): void
    {
        $this->travelBackType = $travelBackType;
    }

    /**
     * @return mixed
     */
    public function getTravelBackDate()
    {
        return $this->travelBackDate;
    }

    /**
     * @param mixed $travelBackDate
     */
    public function setTravelBackDate($travelBackDate): void
    {
        $this->travelBackDate = $travelBackDate;
    }

    /**
     * @return mixed
     */
    public function getBoardingPoint()
    {
        return $this->boardingPoint;
    }

    /**
     * @param mixed $boardingPoint
     */
    public function setBoardingPoint($boardingPoint): void
    {
        $this->boardingPoint = $boardingPoint;
    }

    /**
     * @return mixed
     */
    public function getActivityOption()
    {
        return $this->activityOption;
    }

    /**
     * @param mixed $activityOption
     */
    public function setActivityOption($activityOption): void
    {
        $this->activityOption = $activityOption;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return mixed
     */
    public function getGroupPreference()
    {
        return $this->groupPreference;
    }

    /**
     * @param mixed $groupPreference
     */
    public function setGroupPreference($groupPreference): void
    {
        $this->groupPreference = $groupPreference;
    }

    /**
     * @return mixed
     */
    public function getLodgingLayout()
    {
        return $this->LodgingLayout;
    }

    /**
     * @param mixed $LodgingLayout
     */
    public function setLodgingLayout($LodgingLayout): void
    {
        $this->LodgingLayout = $LodgingLayout;
    }

    /**
     * @return mixed
     */
    public function getGroupLayout()
    {
        return $this->groupLayout;
    }

    /**
     * @param mixed $groupLayout
     */
    public function setGroupLayout($groupLayout): void
    {
        $this->groupLayout = $groupLayout;
    }

    /**
     * @return mixed
     */
    public function getBookerPayed()
    {
        return $this->bookerPayed;
    }

    /**
     * @param mixed $bookerPayed
     */
    public function setBookerPayed($bookerPayed): void
    {
        $this->bookerPayed = $bookerPayed;
    }

    /**
     * @return mixed
     */
    public function getPayerId()
    {
        return $this->payerId;
    }

    /**
     * @param mixed $payerId
     */
    public function setPayerId($payerId): void
    {
        $this->payerId = $payerId;
    }

    /**
     * @return mixed
     */
    public function getisCamper()
    {
        return $this->isCamper;
    }

    /**
     * @param mixed $isCamper
     */
    public function setIsCamper($isCamper): void
    {
        $this->isCamper = $isCamper;
    }

    /**
     * @return mixed
     */
    public function getCheckedIn()
    {
        return $this->checkedIn;
    }

    /**
     * @param mixed $checkedIn
     */
    public function setCheckedIn($checkedIn): void
    {
        $this->checkedIn = $checkedIn;
    }

    /**
     * @return mixed
     */
    public function getTotalExclInsurance()
    {
        return $this->totalExclInsurance;
    }

    /**
     * @param mixed $totalExclInsurance
     */
    public function setTotalExclInsurance($totalExclInsurance): void
    {
        $this->totalExclInsurance = $totalExclInsurance;
    }

    /**
     * @return mixed
     */
    public function getInsuranceValue()
    {
        return $this->insuranceValue;
    }

    /**
     * @param mixed $insuranceValue
     */
    public function setInsuranceValue($insuranceValue): void
    {
        $this->insuranceValue = $insuranceValue;
    }



}
