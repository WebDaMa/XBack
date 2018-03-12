<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupTypeRepository")
 */
class GroupType extends TypeAgency
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="groupPreference")
     */
    private $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
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
        $customer->setGroupPreference($this);
    }

    public function removeCustomer(Customer $customer)
    {
        if (!$this->customers->contains($customer)) {
            return;
        }

        $this->customers->removeElement($customer);
        // set the owning side to null
        $customer->setGroupPreference(null);
    }

}
