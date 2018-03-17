<?php

namespace App\Entity;

use App\Entity\Base\TypeTimestamps;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment extends TypeTimestamps
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * Many Payments have One Customer.
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="payments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $customer;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;
    }

    public function __toString()
    {
        return $this->getCustomer()->getLastName() . ' ' . $this->getCustomer()->getFirstName()
            . ' - ' . $this->getDescription() . ' (' . $this->getPrice() . '€)';
    }

}
