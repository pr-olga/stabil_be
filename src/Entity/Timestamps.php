<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait Timestamps
{
    /**
     * @ORM\Column{type="datetime"}
     */
    private $createdAt;

    /**
     * @ORM\Column{type="datetime"}
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     */
    public function createdAt()
    {
        $time = new \DateTime();
        $this->createdAt = $time->format('Y-m-d H:i:s');
        $this->updatedAt = $time->format('Y-m-d H:i:s');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $time = new \DateTime();
        $this->updatedAt = $time->format('Y-m-d H:i:s');
    }
}
