<?php

namespace App\Entity;

use App\Entity\Base\TypeBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TravelTypeRepository")
 */
class TravelType extends TypeBase
{

    /**
     * @ORM\Column(type="string")
     */
    private $startPoint;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TransportType", inversedBy="travelTypes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $transportType;

    /**
     * @return mixed
     */
    public function getTransportType(): ?TransportType
    {
        return $this->transportType;
    }

    /**
     * @param mixed $transportType
     */
    public function setTransportType(TransportType $transportType = null)
    {
        $this->transportType = $transportType;
    }

    /**
     * @return mixed
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * @param mixed $startPoint
     */
    public function setStartPoint($startPoint): void
    {
        $this->startPoint = $startPoint;
    }

}
