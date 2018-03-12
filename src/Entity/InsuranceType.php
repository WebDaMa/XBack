<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceTypeRepository")
 */
class InsuranceType extends TypeAgency
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="insuranceType")
     */
    private $insCustomers;

    /**
     * @ORM\Column(type="integer")
     */
    private $insuranceCode;

    /**
     * @ORM\Column(type="string")
     */
    private $insuranceName;

    public function __construct()
    {
        $this->insCustomers = new ArrayCollection();
    }

    /**
     * @return Collection|Customer[]
     */
    public function getInsCustomers()
    {
        return $this->insCustomers;
    }

    public function addInsCustomer(Customer $customer)
    {
        if ($this->insCustomers->contains($customer)) {
            return;
        }

        $this->insCustomers->add($customer);
        // set the *owning* side!
        $customer->setInsuranceType($this);
    }

    public function removeInsCustomer(Customer $customer)
    {
        if (!$this->insCustomers->contains($customer)) {
            return;
        }

        $this->insCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setInsuranceType(null);
    }

    /**
     * @return mixed
     */
    public function getInsuranceCode()
    {
        return $this->insuranceCode;
    }

    /**
     * @param mixed $insuranceCode
     */
    public function setInsuranceCode($insuranceCode): void
    {
        $this->insuranceCode = $insuranceCode;
    }

    /**
     * @return mixed
     */
    public function getInsuranceName()
    {
        return $this->insuranceName;
    }

    /**
     * @param mixed $insuranceName
     */
    public function setInsuranceName($insuranceName): void
    {
        $this->insuranceName = $insuranceName;
    }

}
