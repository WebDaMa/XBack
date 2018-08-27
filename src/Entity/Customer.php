<?php

namespace App\Entity;

use App\Entity\Base\TypeTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer extends TypeTimestamps
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $booker;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="App\Entity\SuitSize", inversedBy="suitCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $sizeInfo;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="agencyCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="locCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDay;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDay;

    /**
     * @ORM\ManyToOne(targetEntity="ProgramType", inversedBy="programCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $programType;

    /**
     * @ORM\ManyToOne(targetEntity="LodgingType", inversedBy="lodgingCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lodgingType;

    /**
     * @ORM\ManyToOne(targetEntity="AllInType", inversedBy="allCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $allInType;

    /**
     * @ORM\ManyToOne(targetEntity="InsuranceType", inversedBy="insCustomers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $insuranceType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TravelType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $travelGoType;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $travelGoDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TravelType")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupType", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $groupPreference;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lodgingLayout;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groep", inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $groupLayout;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bookerPayed;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Customer")
     */
    private $payerId;

    /**
     * One Payer has Many Customers.
     * @ORM\OneToMany(targetEntity="Customer", mappedBy="payer")
     */
    private $payerCustomers;

    /**
     * Many payerCustomer have One Customer(Payer).
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="payerCustomers")
     */
    private $payer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCamper;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $payed;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $checkedIn;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $busToCheckedIn;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $busBackCheckedIn;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalExclInsurance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $insuranceValue;

    /**
     * One Customer has Many Payments.
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="customer")
     */
    private $payments;

    /**
     * Many Customers have Many Options.
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity", inversedBy="customers")
     * @ORM\JoinTable(name="customers_activities")
     */
    private $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->payerCustomers = new ArrayCollection();
    }

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
    public function getSize(): ?SuitSize
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize(SuitSize $size = null)
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
    public function getAgency() : ?Agency
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency = null)
    {
        $this->agency = $agency;
    }

    /**
     * @return mixed
     */
    public function getLocation() : ?Location
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation(Location $location = null)
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
    public function getProgramType(): ?ProgramType
    {
        return $this->programType;
    }

    /**
     * @param mixed $programType
     */
    public function setProgramType(ProgramType $programType = null)
    {
        $this->programType = $programType;
    }

    /**
     * @return mixed
     */
    public function getLodgingType(): ?LodgingType
    {
        return $this->lodgingType;
    }

    /**
     * @param mixed $lodgingType
     */
    public function setLodgingType(LodgingType $lodgingType = null)
    {
        $this->lodgingType = $lodgingType;
    }

    /**
     * @return mixed
     */
    public function getAllInType() : ?AllInType
    {
        return $this->allInType;
    }

    /**
     * @param mixed $allInType
     */
    public function setAllInType(AllInType $allInType = null)
    {
        $this->allInType = $allInType;
    }

    /**
     * @return mixed
     */
    public function getInsuranceType(): ?InsuranceType
    {
        return $this->insuranceType;
    }

    /**
     * @param mixed $insuranceType
     */
    public function setInsuranceType(InsuranceType $insuranceType = null)
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
    public function getGroupPreference(): ?GroupType
    {
        return $this->groupPreference;
    }

    /**
     * @param mixed $groupPreference
     */
    public function setGroupPreference(GroupType $groupPreference = null)
    {
        $this->groupPreference = $groupPreference;
    }

    /**
     * @return mixed
     */
    public function getLodgingLayout()
    {
        return $this->lodgingLayout;
    }

    /**
     * @param mixed $LodgingLayout
     */
    public function setLodgingLayout($LodgingLayout): void
    {
        $this->lodgingLayout = $LodgingLayout;
    }

    /**
     * @return mixed
     */
    public function getGroupLayout(): ?Groep
    {
        return $this->groupLayout;
    }

    /**
     * @param mixed $groupLayout
     */
    public function setGroupLayout(Groep $groupLayout = null)
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
    public function getPayerId() : ?Customer
    {
        return $this->payerId;
    }

    /**
     * @param mixed $payerId
     */
    public function setPayerId(Customer $payerId = null): void
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
    public function getBusToCheckedIn()
    {
        return $this->busToCheckedIn;
    }

    /**
     * @param mixed $busToCheckedIn
     */
    public function setBusToCheckedIn($busToCheckedIn): void
    {
        $this->busToCheckedIn = $busToCheckedIn;
    }

    /**
     * @return mixed
     */
    public function getBusBackCheckedIn()
    {
        return $this->busBackCheckedIn;
    }

    /**
     * @param mixed $busBackCheckedIn
     */
    public function setBusBackCheckedIn($busBackCheckedIn): void
    {
        $this->busBackCheckedIn = $busBackCheckedIn;
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

    /**
     * @return mixed
     */
    public function getSizeInfo()
    {
        return $this->sizeInfo;
    }

    /**
     * @param mixed $sizeInfo
     */
    public function setSizeInfo($sizeInfo): void
    {
        $this->sizeInfo = $sizeInfo;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities()
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity)
    {
        if ($this->activities->contains($activity)) {
            return;
        }

        $this->activities->add($activity);
        // set the *owning* side!
        $activity->addCustomer($this);
    }

    public function removeActivity(Activity $activity)
    {
        if (!$this->activities->contains($activity)) {
            return;
        }

        $this->activities->removeElement($activity);
        // set the owning side to null
        $activity->removeCustomer($this);
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment)
    {
        if ($this->payments->contains($payment)) {
            return;
        }

        $this->payments->add($payment);
        // set the *owning* side!
        $payment->setCustomer($this);
    }

    public function removePayment(Payment $payment)
    {
        if (!$this->payments->contains($payment)) {
            return;
        }

        $this->payments->removeElement($payment);
        // set the owning side to null
        $payment->setCustomer(null);
    }

    /**
     * @return Collection|Customer[]
     */
    public function getPayerCustomers()
    {
        return $this->payerCustomers;
    }

    public function addPayerCustomer(Customer $customer)
    {
        if ($this->payerCustomers->contains($customer)) {
            return;
        }

        $this->payerCustomers->add($customer);
        // set the *owning* side!
        $customer->setPayerId($this);
    }

    public function removePayerCustomer(Customer $customer)
    {
        if (!$this->payerCustomers->contains($customer)) {
            return;
        }

        $this->payerCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setPayerId(null);
    }

    /**
     * @return mixed
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * @param mixed $payed
     */
    public function setPayed($payed): void
    {
        $this->payed = $payed;
    }

    public function __toString() : string
    {
        return (string) $this->getFirstName() . ' ' . $this->getLastName() . ' (' . $this->getBookerId() . ')';
    }

}
