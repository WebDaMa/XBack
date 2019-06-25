<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncludeOptionRepository")
 * @UniqueEntity(fields={"programType"})
 */
class IncludeOption
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgramType")
     */
    private $programType;

    public function getId(): ?int
    {
        return $this->id;
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
    public function setProgramType(ProgramType $programType)
    {
        $this->programType = $programType;
    }
}
