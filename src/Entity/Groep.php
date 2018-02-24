<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class Groep
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="group")
     */
    private $groupPlannings;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    // add your own fields

    /**
     * @ORM\Column(type="integer")
     */
    protected $groupId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $periodId;

    /**
     * @ORM\Column(type="string")
     */
    protected $location;

    public function __construct()
    {
        $this->groupPlannings = new ArrayCollection();
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
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
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
     * @return mixed
     */
    public function getPeriodId()
    {
        return $this->periodId;
    }

    /**
     * @param mixed $periodId
     */
    public function setPeriodId($periodId): void
    {
        $this->periodId = $periodId;
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

    /**
     * @return Collection|Customer[]
     */
    public function getGroupPlannings()
    {
        return $this->groupPlannings;
    }

    public function addGroupPlanning(Planning $planning)
    {
        if ($this->groupPlannings->contains($planning)) {
            return;
        }

        $this->groupPlannings[] = $planning;
        // set the *owning* side!
        $planning->setGuide($this);
    }

    public function removeGroupPlanning(Planning $planning)
    {
        $this->groupPlannings->removeElement($planning);
        // set the owning side to null
        $planning->setGuide(null);
    }

    public function __toString() : string
    {
        return (string) $this->getName() . ' - ' . $this->getPeriodId();
    }

}
