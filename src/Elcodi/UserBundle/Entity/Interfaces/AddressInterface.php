<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\UserBundle\Entity\Interfaces;

use DateTime;

/**
 * Address Interface
 */
interface AddressInterface
{
    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress($address);

    /**
     * Return address value
     *
     * @return string Address value
     */
    public function getAddress();

    /**
     * Set locally created at value
     *
     * @param DateTime $createdAt Updatedat value
     *
     * @return AddressInterface self Object
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
     * @return AddressInterface self Object
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * Return updated_at value
     *
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * Set if is enabled
     *
     * @param boolean $enabled enabled value
     *
     * @return AddressInterface self Object
     */
    public function setEnabled($enabled);

    /**
     * Get is enabled
     *
     * @return boolean is enabled
     */
    public function isEnabled();
}
