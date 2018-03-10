<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityGroupRepository")
 */
class ActivityGroup extends TypeName
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="activityGroup")
     */
    private $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities()
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity)
    {
        if ($this->activities->contains($activity)) {
            return;
        }

        $this->activities[] = $activity;
        // set the *owning* side!
        $activity->setActivityGroup($this);
    }

    public function removeActivity(Activity $activity)
    {
        $this->activities->removeElement($activity);
        // set the owning side to null
        $activity->setActivityGroup(null);
    }
}
