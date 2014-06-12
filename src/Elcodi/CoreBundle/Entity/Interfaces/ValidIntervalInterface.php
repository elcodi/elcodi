<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Entity\Interfaces;

use DateTime;

/**
 * Class ValidIntervalInterface
 */
interface ValidIntervalInterface
{
    /**
     * Set valid from
     *
     * @param DateTime $validFrom Valid from
     *
     * @return Object self Object
     */
    public function setValidFrom(DateTime $validFrom);

    /**
     * Get valid from
     *
     * @return DateTime
     */
    public function getValidFrom();

    /**
     * Set valid to
     *
     * @param DateTime $validTo Valid to
     *
     * @return Object self Object
     */
    public function setValidTo(DateTime $validTo = null);

    /**
     * Get valid to
     *
     * @return DateTime Valid to
     */
    public function getValidTo();
}
