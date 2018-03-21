<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SuitSizeRepository")
 */
class SuitSize extends TypeName
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="size")
     */
    private $suitCustomers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BeltSize", inversedBy="beltSuitSizes")
     */
    private $beltSize;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HelmSize", inversedBy="helmSuitSizes")
     */
    private $helmSize;

    public function __construct()
    {
        $this->suitCustomers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBeltSize(): ?BeltSize
    {
        return $this->beltSize;
    }

    /**
     * @param mixed $beltSize
     */
    public function setBeltSize(BeltSize $beltSize)
    {
        $this->beltSize = $beltSize;
    }

    /**
     * @return mixed
     */
    public function getHelmSize(): ?HelmSize
    {
        return $this->helmSize;
    }

    /**
     * @param mixed $helmSize
     */
    public function setHelmSize(HelmSize $helmSize)
    {
        $this->helmSize = $helmSize;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getSuitCustomers()
    {
        return $this->suitCustomers;
    }

    public function addSuitCustomer(Customer $customer)
    {
        if ($this->suitCustomers->contains($customer)) {
            return;
        }

        $this->suitCustomers->add($customer);
        // set the *owning* side!
        $customer->setSize($this);
    }

    public function removeSuitCustomer(Customer $customer)
    {
        if (!$this->suitCustomers->contains($customer)) {
            return;
        }

        $this->suitCustomers->removeElement($customer);
        // set the owning side to null
        $customer->setSize(null);
    }


}
