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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    // add your own fields

    /**
     * @ORM\Column(type="string")
     */
    protected $guideShort;

    /**
     * @ORM\Column(type="string")
     */
    protected $guideFirstName;

    /**
     * @ORM\Column(type="string")
     */
    protected $guideLastName;

    public function __construct()
    {
        $this->plannings = new ArrayCollection();
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

    public function __toString() : string
    {
        return (string) $this->getGuideShort() . ' - ' . $this->getGuideFirstName() .
            ' ' . $this->getGuideLastName();
    }

}
