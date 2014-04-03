<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for DateTime common variables and methods
 */
trait DateTimeTrait
{
    /**
     * @var \DateTime
     *
     * @\Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @\Doctrine\ORM\Mapping\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @\Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @\Doctrine\ORM\Mapping\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * Return created_at value
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Return updated_at value
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Method triggered by LifeCycleEvent. Sets or updates $this->updatedAt
     *
     * @Doctrine\ORM\Mapping\PrePersist()
     * @Doctrine\ORM\Mapping\PreUpdate()
     */
    public function loadUpdateAt()
    {
        $this->setUpdatedAt(new \DateTime);
    }

    /**
     * Set locally updated at value
     *
     * @param \DateTime $updatedAt Updatedat value
     *
     * @return Object self Object
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Set locally created at value
     *
     * @param \DateTime $createdAt Updatedat value
     *
     * @return Object self Object
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Checks whether this product qualifies as 'new'
     *
     * @return bool Entity is new
     */
    public function isNew()
    {
        return ($this->getCreatedAt()->diff(new \DateTime())->days <= 30);
    }
}
