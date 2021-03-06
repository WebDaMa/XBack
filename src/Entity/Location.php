<?php

namespace App\Entity;

use App\Entity\Base\TypeBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location extends TypeBase
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="location")
     */
    private $locCustomers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groep", mappedBy="location")
     */
    private $locGroeps;

    public function __construct()
    {
        $this->locCustomers = new ArrayCollection();
        $this->locGroeps = new ArrayCollection();
    }

    /**
     * @return Collection|Customer[]
     */
    public function getLocCustomers()
    {
        return $this->locCustomers;
    }

    public function addLocCustomer(Customer $customer)
    {
        if ($this->locCustomers->contains($customer)) {
            return;
        }

        $this->locCustomers->add($customer);
        // set the *owning* side!
        $customer->setLocation($this);
    }

    public function removeLocCustomer(Customer $customer)
    {
        if (!$this->locCustomers->contains($customer)) {
            return;
        }

        $this->locCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setLocation(null);
    }

    /**
     * @return Collection|Groep[]
     */
    public function getLocGroeps()
    {
        return $this->locGroeps;
    }

    public function addLocGroep(Groep $groep)
    {
        if ($this->locGroeps->contains($groep)) {
            return;
        }

        $this->locGroeps->add($groep);
        // set the *owning* side!
        $groep->setLocation($this);
    }

    public function removeLocGroep(Groep $groep)
    {
        if (!$this->locGroeps->contains($groep)) {
            return;
        }

        $this->locGroeps->removeElement($groep);
        // set the owning side to null
        $groep->setLocation(null);
    }
}
