<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use App\Entity\Base\TypeTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\GroepRepository")
 */
class Groep extends TypeTimestamps
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="group")
     */
    private $plannings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="groupLayout")
     * @ORM\OrderBy({"firstName" = "ASC"})
     */
    private $groupCustomers;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="integer")
     */
    private $groupIndex;

    /**
     * @ORM\Column(type="integer")
     */
    private $groupId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $periodId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="locGroeps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="agencyGroeps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    public function __construct()
    {
        $this->plannings = new ArrayCollection();
        $this->groupCustomers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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
    public function getLocation(): ?Location
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
     * @return Collection|Planning[]
     */
    public function getPlannings()
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning)
    {
        if ($this->plannings->contains($planning)) {
            return;
        }

        $this->plannings->add($planning);
        // set the *owning* side!
        $planning->setGroup($this);
    }

    public function removePlanning(Planning $planning)
    {
        if (!$this->plannings->contains($planning)) {
            return;
        }

        $this->plannings->removeElement($planning);
        // set the owning side to null
        $planning->setGroup(null);
    }

    /**
     * @return Collection|Customer[]
     */
    public function getGroupCustomers()
    {
        return $this->groupCustomers;
    }

    public function addGroupCustomer(Customer $customer)
    {
        if ($this->groupCustomers->contains($customer)) {
            return;
        }

        $this->groupCustomers->add($customer);
        // set the *owning* side!
        $customer->setGroupLayout($this);
    }

    public function removeGroupCustomer(Customer $customer)
    {
        if (!$this->groupCustomers->contains($customer)) {
            return;
        }

        $this->groupCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setGroupLayout(null);
    }

    /**
     * @return mixed
     */
    public function getGroupIndex()
    {
        return $this->groupIndex;
    }

    /**
     * @param mixed $groupIndex
     */
    public function setGroupIndex($groupIndex): void
    {
        $this->groupIndex = $groupIndex;
    }

    /**
     * @return mixed
     */
    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency = null): void
    {
        $this->agency = $agency;
    }

    public function __toString() : string
    {
        return (string) $this->getName() . ' - ' . $this->getPeriodId();
    }

}
