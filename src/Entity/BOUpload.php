<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BOUploadRepository")
 */
class BOUpload
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the BO list as an Excel file.")
     * @Assert\File()
     */
    private $boPeriodFile;

    public function getBoPeriodFile()
    {
        return $this->boPeriodFile;
    }

    public function setBoPeriodFile($boPeriodFile)
    {
        $this->boPeriodFile = $boPeriodFile;

        return $this;
    }

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

}
