<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LodgingTypeRepository")
 */
class LodgingType extends TypeAgency
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="lodgingType")
     */
    private $lodgingCustomers;

    public function __construct()
    {
        $this->lodgingCustomers = new ArrayCollection();
    }

    /**
     * @return Collection|Customer[]
     */
    public function getLodgingCustomers()
    {
        return $this->lodgingCustomers;
    }

    public function addLodgingCustomer(Customer $customer)
    {
        if ($this->lodgingCustomers->contains($customer)) {
            return;
        }

        $this->lodgingCustomers[] = $customer;
        // set the *owning* side!
        $customer->setLodgingType($this);
    }

    public function removeLodgingCustomer(Customer $customer)
    {
        $this->lodgingCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setLodgingType(null);
    }
}
