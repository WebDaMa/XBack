<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 */
class Program extends TypeName
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgramActivity", mappedBy="program")
     */
    private $activityPrograms;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgramGroup", inversedBy="programs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $programGroup;

    /**
     * @ORM\Column(type="integer")
     */
    private $days;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgramType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $programType;

    public function __construct()
    {
        $this->activityPrograms = new ArrayCollection();
    }

    /**
     * @return Collection|ProgramActivity[]
     */
    public function getAgencyCustomers()
    {
        return $this->activityPrograms;
    }

    public function addProgramActivity(ProgramActivity $programActivity)
    {
        if ($this->activityPrograms->contains($programActivity)) {
            return;
        }

        $this->activityPrograms[] = $programActivity;
        // set the *owning* side!
        $programActivity->setProgram($this);
    }

    public function removeProgramActivity(ProgramActivity $programActivity)
    {
        $this->activityPrograms->removeElement($programActivity);
        // set the owning side to null
        $programActivity->setProgram(null);
    }

    /**
     * @return mixed
     */
    public function getAgency(): ?Agency
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
     * @return mixed
     */
    public function getProgramGroup() : ?ProgramGroup
    {
        return $this->programGroup;
    }

    /**
     * @param mixed $programGroup
     */
    public function setProgramGroup(ProgramGroup $programGroup = null)
    {
        $this->programGroup = $programGroup;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days): void
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getProgramType() : ?ProgramType
    {
        return $this->programType;
    }

    /**
     * @param mixed $programType
     */
    public function setProgramType(ProgramType $programType = null)
    {
        $this->programType = $programType;
    }


}
