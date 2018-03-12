<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransportTypeRepository")
 */
class TransportType extends TypeName
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TravelType", mappedBy="transportType")
     */
    private $travelTypes;

    public function __construct()
    {
        $this->travelTypes = new ArrayCollection();
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

        $this->travelTypes->add($travelType);
        // set the *owning* side!
        $travelType->setTransportType($this);
    }

    public function removeTravelType(TravelType $travelType)
    {
        if (!$this->travelTypes->contains($travelType)) {
            return;
        }

        $this->travelTypes->removeElement($travelType);
        // set the owning side to null
        $travelType->setTransportType(null);
    }

}
