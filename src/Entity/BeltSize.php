<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeltSizeRepository")
 */
class BeltSize extends Size
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SuitSize", mappedBy="beltSize")
     */
    private $beltSuitSizes;

    public function __construct()
    {
        $this->beltSuitSizes = new ArrayCollection();
    }

    /**
     * @return Collection|SuitSize[]
     */
    public function getBeltSuitSizes()
    {
        return $this->beltSuitSizes;
    }

    public function addBeltSuitSize(SuitSize $suitSize)
    {
        if ($this->beltSuitSizes->contains($suitSize)) {
            return;
        }

        $this->beltSuitSizes[] = $suitSize;
        // set the *owning* side!
        $suitSize->setBeltSize($this);
    }

    public function removeBeltSuitSize(SuitSize $suitSize)
    {
        $this->beltSuitSizes->removeElement($suitSize);
        // set the owning side to null
        $suitSize->setBeltSize(null);
    }
}
