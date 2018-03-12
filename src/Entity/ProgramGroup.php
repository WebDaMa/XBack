<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramGroupRepository")
 */
class ProgramGroup extends TypeName
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="activityGroup")
     */
    private $programs;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms()
    {
        return $this->programs;
    }

    public function addProgram(Program $program)
    {
        if ($this->programs->contains($program)) {
            return;
        }

        $this->programs->add($program);
        // set the *owning* side!
        $program->setProgramGroup($this);
    }

    public function removeProgram(Program $program)
    {
        if (!$this->programs->contains($program)) {
            return;
        }

        $this->programs->removeElement($program);
        // set the owning side to null
        $program->setProgramGroup(null);
    }
}
