<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AllInTypeRepository")
 */
class AllInType extends TypeAgency {

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="allInType")
     */
    private $allCustomers;

    /**
     * @ORM\Column(type="float")
     */
    private $prize;

    public function __construct()
    {
        $this->allCustomers = new ArrayCollection();
    }

    /**
     * @return Collection|Customer[]
     */
    public function getAllCustomers()
    {
        return $this->allCustomers;
    }

    public function addAllCustomer(Customer $customer)
    {
        if ($this->allCustomers->contains($customer))
        {
            return;
        }

        $this->allCustomers->add($customer);
        // set the *owning* side!
        $customer->setAllInType($this);
    }

    public function removeInsCustomer(Customer $customer)
    {
        if (!$this->allCustomers->contains($customer)) {
            return;
        }

        $this->allCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setAllInType(null);
    }

    /**
     * @return mixed
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * @param mixed $prize
     */
    public function setPrize($prize): void
    {
        $this->prize = $prize;
    }

}
