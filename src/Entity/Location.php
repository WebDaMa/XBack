<?php

namespace App\Entity;

use App\Entity\Base\TypeBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location extends TypeBase
{
}
