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
 * Class DateTimeInterface
 */
interface DateTimeInterface
{
    /**
     * Set locally created at value
     *
     * @param DateTime $createdAt Created at value
     *
     * @return DateTimeInterface self Object
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * Return created_at value
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set locally updated at value
     *
     * @param DateTime $updatedAt Updated at value
     *
     * @return DateTimeInterface self Object
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * Return updated_at value
     *
     * @return DateTime
     */
    public function getUpdatedAt();
}
