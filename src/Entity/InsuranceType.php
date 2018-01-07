<?php

namespace App\Entity;

use App\Entity\Base\TypeAgency;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceTypeRepository")
 */
class InsuranceType extends TypeAgency
{
}
