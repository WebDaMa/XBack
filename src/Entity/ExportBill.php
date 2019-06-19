<?php

namespace App\Entity;

use App\Entity\Base\TypeTimestamps;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\ExportBillRepository")
 */
class ExportBill extends TypeTimestamps
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $period;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=true)
     */
    private $location;

    /**
     * ExportRaft constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId(): ?Int
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
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param mixed $period
     */
    public function setPeriod($period): void
    {
        $this->period = $period;
    }

    /**
     * @return mixed
     */
    public function getLocation() : ?Location
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation(Location $location = null)
    {
        $this->location = $location;
    }

}
