<?php

namespace App\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

class TypeTimestamps
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $modified_at;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * @param mixed $modified_at
     */
    public function setModifiedAt($modified_at): void
    {
        $this->modified_at = $modified_at;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setModifiedAt(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

}
