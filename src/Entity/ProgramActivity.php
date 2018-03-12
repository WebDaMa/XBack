<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramActivityRepository")
 */
class ProgramActivity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program", inversedBy="activityPrograms")
     * @ORM\JoinColumn(nullable=true)
     */
    private $program;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="programActivities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $activity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $optional;

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
    public function getProgram() : ?Program
    {
        return $this->program;
    }

    /**
     * @param mixed $program
     */
    public function setProgram(Program $program = null)
    {
        $this->program = $program;
    }

    /**
     * @return mixed
     */
    public function getActivity() : ?Activity
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity(Activity $activity = null)
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param mixed $optional
     */
    public function setOptional($optional): void
    {
        $this->optional = $optional;
    }

    public function __toString() : string
    {
        return (string) $this->getProgram()->__toString() . ' - ' . $this->getActivity()->__toString();
    }
}
