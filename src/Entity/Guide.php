<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Group
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
    protected $groupId;

    /**
     * @ORM\Column(type="string")
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

    public function __toString() : string
    {
        return (string) $this->getName() . ' - ' . $this->getPeriodId();
    }

}
