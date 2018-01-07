<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AllInTypeRepository")
 */
class AllInType extends TypeAgency
{

}
