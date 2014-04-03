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

namespace Elcodi\UserBundle\Entity\Interfaces;

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

    public function setEnabled($enabled);

    public function isEnabled();

    public function setCreatedAt(\DateTime $createdAt);

    public function getCreatedAt();

    public function setUpdatedAt(\DateTime $createdAt);

    public function getUpdatedAt();

}