<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GuideRepository")
 */
class Guide
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="guide")
     */
    private $plannings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="cag1")
     */
    private $planningsCag1;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="cag2")
     */
    private $planningsCag2;

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
    private $guideShort;

    /**
     * @ORM\Column(type="string")
     */
    private $guideFirstName;

    /**
     * @ORM\Column(type="string")
     */
    private $guideLastName;

    public function __construct()
    {
        $this->plannings = new ArrayCollection();
        $this->planningsCag1 = new ArrayCollection();
        $this->planningsCag2 = new ArrayCollection();
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
    public function getGuideShort()
    {
        return $this->guideShort;
    }

    /**
     * @param mixed $guideShort
     */
    public function setGuideShort($guideShort): void
    {
        $this->guideShort = $guideShort;
    }

    /**
     * @return mixed
     */
    public function getGuideFirstName()
    {
        return $this->guideFirstName;
    }

    /**
     * @param mixed $guideFirstName
     */
    public function setGuideFirstName($guideFirstName): void
    {
        $this->guideFirstName = $guideFirstName;
    }

    /**
     * @return mixed
     */
    public function getGuideLastName()
    {
        return $this->guideLastName;
    }

    /**
     * @param mixed $guideLastName
     */
    public function setGuideLastName($guideLastName): void
    {
        $this->guideLastName = $guideLastName;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlannings()
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning)
    {
        if ($this->plannings->contains($planning)) {
            return;
        }

        $this->plannings->add($planning);
        // set the *owning* side!
        $planning->setGuide($this);
    }

    public function removePlanning(Planning $planning)
    {
        if (!$this->plannings->contains($planning)) {
            return;
        }

        $this->plannings->removeElement($planning);
        // set the owning side to null
        $planning->setGuide(null);
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlanningsCag2()
    {
        return $this->planningsCag2;
    }

    public function addPlanningCag2(Planning $planning)
    {
        if ($this->planningsCag2->contains($planning)) {
            return;
        }

        $this->planningsCag2->add($planning);
        // set the *owning* side!
        $planning->setGuide($this);
    }

    public function removePlanningCag2(Planning $planning)
    {
        if (!$this->planningsCag2->contains($planning)) {
            return;
        }

        $this->planningsCag2->removeElement($planning);
        // set the owning side to null
        $planning->setGuide(null);
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlanningsCag1()
    {
        return $this->planningsCag1;
    }

    public function addPlanningCag1(Planning $planning)
    {
        if ($this->planningsCag1->contains($planning)) {
            return;
        }

        $this->planningsCag1->add($planning);
        // set the *owning* side!
        $planning->setGuide($this);
    }

    public function removePlanningCag1(Planning $planning)
    {
        if (!$this->planningsCag1->contains($planning)) {
            return;
        }

        $this->planningsCag1->removeElement($planning);
        // set the owning side to null
        $planning->setGuide(null);
    }

    public function __toString() : string
    {
        return (string) $this->getGuideShort() . ' - ' . $this->getGuideFirstName() .
            ' ' . $this->getGuideLastName();
    }

}
