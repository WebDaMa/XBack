<?php

namespace App\Entity\Base;

use App\Entity\Agency;
use Doctrine\ORM\Mapping as ORM;

class TypeAgency extends TypeBase
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $agency;

    /**
     * @return mixed
     */
    public function getAgency()
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

}
