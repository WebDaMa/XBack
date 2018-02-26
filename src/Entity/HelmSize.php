<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HelmSizeRepository")
 */
class HelmSize extends Size
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SuitSize", mappedBy="helmSize")
     */
    private $helmSuitSizes;

    public function __construct()
    {
        $this->helmSuitSizes = new ArrayCollection();
    }

    /**
     * @return Collection|SuitSize[]
     */
    public function getHelmSuitSizes()
    {
        return $this->helmSuitSizes;
    }

    public function addHelmSuitSize(SuitSize $suitSize)
    {
        if ($this->helmSuitSizes->contains($suitSize)) {
            return;
        }

        $this->helmSuitSizes[] = $suitSize;
        // set the *owning* side!
        $suitSize->setHelmSize($this);
    }

    public function removeHelmSuitSize(SuitSize $suitSize)
    {
        $this->helmSuitSizes->removeElement($suitSize);
        // set the owning side to null
        $suitSize->setHelmSize(null);
    }
}
