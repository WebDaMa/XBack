<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning
{

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
    protected $planningId;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groep", inversedBy="groupPlannings")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $group;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $activity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guide", inversedBy="plannings")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $guide;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $guideFunction;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $print;

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
    public function getPlanningId()
    {
        return $this->planningId;
    }

    /**
     * @param mixed $planningId
     */
    public function setPlanningId($planningId): void
    {
        $this->planningId = $planningId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity): void
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getGroup(): ?Groep
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup(Groep $group = null)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getGuide() : ?Guide
    {
        return $this->guide;
    }

    /**
     * @param mixed $guide
     */
    public function setGuide(Guide $guide = null)
    {
        $this->guide = $guide;
    }

    /**
     * @return mixed
     */
    public function getGuideFunction()
    {
        return $this->guideFunction;
    }

    /**
     * @param mixed $guideFunction
     */
    public function setGuideFunction($guideFunction): void
    {
        $this->guideFunction = $guideFunction;
    }

    /**
     * @return mixed
     */
    public function getPrint()
    {
        return $this->print;
    }

    /**
     * @param mixed $print
     */
    public function setPrint($print)
    {
        $this->print = $print;
    }

    public function __toString() : string
    {
        return (string) $this->getActivity();
    }

}
