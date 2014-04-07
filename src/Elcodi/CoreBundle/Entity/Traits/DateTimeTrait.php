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
     * Created at
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * Updated at
     */
    protected $updatedAt;

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
     * Return created_at value
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * Return updated_at value
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Method triggered by LifeCycleEvent.
     * Sets or updates $this->updatedAt
     */
    public function loadUpdateAt()
    {
        $this->setUpdatedAt(new \DateTime);
    }
}
