<?php

namespace App\Entity;

use App\Entity\Base\TypeName;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramGroupRepository")
 */
class ProgramGroup extends TypeName
{
}
