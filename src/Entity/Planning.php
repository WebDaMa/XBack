<?php

namespace App\Entity;

use App\Entity\Base\TypeTimestamps;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning extends TypeTimestamps
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="integer")
     */
    private $planningId;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groep", inversedBy="groupPlannings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $group;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="activityPlannings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guide", inversedBy="plannings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $guide;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $guideFunction;

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
    public function getActivity(): ?Activity
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
