<?php

namespace App\Entity\Base;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class TypeAgency extends TypeBase
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(nullable=true)
     */
    public $agency;

    /**
     * @return mixed
     */
    public function getAgency() : Agency
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency(Agency $agency): void
    {
        $this->agency = $agency;
    }

}
