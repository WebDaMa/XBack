<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use App\Entity\Base\TypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity extends TypeName
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgramActivity", mappedBy="activity")
     */
    private $programActivities;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActivityGroup", inversedBy="activities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $activityGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="activity")
     */
    private $plannings;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Many Activities have Many Customers.
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", mappedBy="activities")
     */
    private $customers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=true)
     */
    private $location;

    public function __construct()
    {
        $this->programActivities = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }

    /**
     * @return Collection|ProgramActivity[]
     */
    public function getProgramActivities()
    {
        return $this->programActivities;
    }

    public function addProgramActivity(ProgramActivity $programActivity)
    {
        if ($this->programActivities->contains($programActivity)) {
            return;
        }

        $this->programActivities->add($programActivity);
        // set the *owning* side!
        $programActivity->setActivity($this);
    }

    public function removeProgramActivity(ProgramActivity $programActivity)
    {
        if (!$this->programActivities->contains($programActivity)) {
            return;
        }

        $this->programActivities->removeElement($programActivity);
        // set the owning side to null
        $programActivity->setActivity(null);
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
        $planning->setActivity($this);
    }

    public function removePlanning(Planning $planning)
    {
        if (!$this->plannings->contains($planning)) {
            return;
        }

        $this->plannings->removeElement($planning);
        // set the owning side to null
        $planning->setActivity(null);
    }

    /**
     * @return mixed
     */
    public function getAgency()
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
    public function getActivityGroup(): ?ActivityGroup
    {
        return $this->activityGroup;
    }

    /**
     * @param mixed $activityGroup
     */
    public function setActivityGroup(ActivityGroup $activityGroup = null)
    {
        $this->activityGroup = $activityGroup;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
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
     * @return Collection|Customer[]
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer)
    {
        if ($this->customers->contains($customer)) {
            return;
        }

        $this->customers->add($customer);
        // set the *owning* side!
        $customer->addActivity($this);
    }

    public function removeCustomer(Customer $customer)
    {
        if (!$this->customers->contains($customer)) {
            return;
        }

        $this->customers->removeElement($customer);
        // set the owning side to null
        $customer->removeActivity($this);
    }


}
