<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramTypeRepository")
 */
class ProgramType extends TypeAgency
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgramActivity", mappedBy="programType")
     */
    private $activityProgramTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="programType")
     */
    private $programCustomers;

    public function __construct()
    {
        $this->programCustomers = new ArrayCollection();
        $this->activityProgramTypes = new ArrayCollection();

    }

    /**
     * @return Collection|Customer[]
     */
    public function getProgramCustomers()
    {
        return $this->programCustomers;
    }

    public function addProgramCustomer(Customer $customer)
    {
        if ($this->programCustomers->contains($customer)) {
            return;
        }

        $this->programCustomers->add($customer);
        // set the *owning* side!
        $customer->setProgramType($this);
    }

    public function removeProgramCustomer(Customer $customer)
    {
        if (!$this->programCustomers->contains($customer)) {
            return;
        }

        $this->programCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setProgramType(null);
    }

    /**
     * @return Collection|ProgramActivity[]
     */
    public function getAgencyCustomers()
    {
        return $this->activityProgramTypes;
    }

    public function addProgramActivity(ProgramActivity $programActivity)
    {
        if ($this->activityProgramTypes->contains($programActivity)) {
            return;
        }

        $this->activityProgramTypes->add($programActivity);
        // set the *owning* side!
        $programActivity->setProgramType($this);
    }

    public function removeProgramActivity(ProgramActivity $programActivity)
    {
        if (!$this->activityProgramTypes->contains($programActivity)) {
            return;
        }

        $this->activityProgramTypes->removeElement($programActivity);
        // set the owning side to null
        $programActivity->setProgramType(null);
    }
}
