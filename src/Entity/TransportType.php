<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransportTypeRepository")
 */
class TransportType
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TravelType", mappedBy="transportType")
     */
    private $travelTypes;

    public function __construct()
    {
        $this->travelTypes = new ArrayCollection();
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection|TravelType[]
     */
    public function getTravelTypes()
    {
        return $this->travelTypes;
    }

    public function addTravelType(TravelType $travelType)
    {
        if ($this->travelTypes->contains($travelType)) {
            return;
        }

        $this->travelTypes[] = $travelType;
        // set the *owning* side!
        $travelType->setTransportType($this);
    }

    public function removeTravelType(TravelType $travelType)
    {
        $this->travelTypes->removeElement($travelType);
        // set the owning side to null
        $travelType->setTransportType(null);
    }

    public function __toString() : string
    {
        return (string) $this->getName();
    }
}
