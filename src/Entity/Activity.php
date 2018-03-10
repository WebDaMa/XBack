<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use App\Entity\Base\TypeName;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity extends TypeName
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActivityGroup", inversedBy="activities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $activityGroup;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=true)
     */
    private $location;

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency = null)
    {
        $this->agency = $agency;
    }

    /**
     * @return mixed
     */
    public function getActivityGroup(): ?ActivityGroup
    {
        return $this->activityGroup;
    }

    /**
     * @param mixed $activityGroup
     */
    public function setActivityGroup(ActivityGroup $activityGroup = null)
    {
        $this->activityGroup = $activityGroup;
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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }
}
