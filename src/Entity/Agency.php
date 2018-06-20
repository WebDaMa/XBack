<?php

namespace App\Entity;

use App\Entity\Base\TypeBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 */
class Agency extends TypeBase
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="agency")
     */
    private $agencyCustomers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groep", mappedBy="agency")
     */
    private $agencyGroeps;

    public function __construct()
    {
        $this->agencyCustomers = new ArrayCollection();
        $this->agencyGroeps = new ArrayCollection();
    }

    /**
     * @return Collection|Customer[]
     */
    public function getAgencyCustomers()
    {
        return $this->agencyCustomers;
    }

    public function addAgencyCustomer(Customer $customer)
    {
        if ($this->agencyCustomers->contains($customer)) {
            return;
        }

        $this->agencyCustomers->add($customer);
        // set the *owning* side!
        $customer->setAgency($this);
    }

    public function removeAgencyCustomer(Customer $customer)
    {
        if (!$this->agencyCustomers->contains($customer)) {
            return;
        }

        $this->agencyCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setAgency(null);
    }

    /**
     * @return Collection|Groep[]
     */
    public function getAgencyGroeps()
    {
        return $this->agencyGroeps;
    }

    public function addAgencyGroep(Groep $groep)
    {
        if ($this->agencyGroeps->contains($groep)) {
            return;
        }

        $this->agencyGroeps->add($groep);
        // set the *owning* side!
        $groep->setAgency($this);
    }

    public function removeAgencyGroep(Groep $groep)
    {
        if (!$this->agencyGroeps->contains($groep)) {
            return;
        }

        $this->agencyGroeps->removeElement($groep);
        // set the owning side to null
        $groep->setAgency(null);
    }
}
