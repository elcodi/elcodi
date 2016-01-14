<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\User\Entity\Traits;

/**
 * Trait LastLoginTrait.
 */
trait LastLoginTrait
{
    /**
     * @var \DateTime
     *
     * Last login date
     */
    protected $lastLoginAt;

    /**
     * Get LastLoginAt.
     *
     * @return \DateTime LastLoginAt
     */
    public function getLastLoginAt()
    {
        return $this->lastLoginAt;
    }

    /**
     * Sets LastLoginAt.
     *
     * @param \DateTime $lastLoginAt LastLoginAt
     *
     * @return $this Self object
     */
    public function setLastLoginAt(\DateTime $lastLoginAt)
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }
}
