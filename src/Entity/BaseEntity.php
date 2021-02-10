<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
class BaseEntity {

    const INTERNAL_STATUS_ENABLED = 1;
    const INTERNAL_STATUS_ARCHIVED = 2;
    const INTERNAL_STATUS_DELETED = 3;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     * @ORM\Column(name="internal_status", type="smallint", length=3, options={"default":true,"comment":"Status interne de l'entité"})
     */
    private $internalStatus;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->internalStatus = self::INTERNAL_STATUS_ENABLED;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BaseEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return BaseEntity
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            //"createdBy"=>$this->getCreatedBy()?$this->getCreatedBy()->toArray2():null,
            //"updatedBy"=>$this->getUpdatedBy()?$this->getUpdatedBy()->toArray2():null,
            "createdAt"=>$this->getCreatedAt()?$this->getCreatedAt()->format("Y-m-d H:i"):null,
            "updatedAt"=>$this->getUpdatedAt()?$this->getUpdatedAt()->format("Y-m-d H:i"):null,
            "internalStatus"=>$this->internalStatus,
        ];
    }

    /**
     * Set internalStatus.
     *
     * @param int $internalStatus
     *
     * @return BaseEntity
     */
    public function setInternalStatus($internalStatus)
    {
        $this->internalStatus = $internalStatus;

        return $this;
    }

    /**
     * Get internalStatus.
     *
     * @return int
     */
    public function getInternalStatus()
    {
        return $this->internalStatus;
    }
}
