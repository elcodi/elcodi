<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Geo\View\Interfaces;

use DateTime;

/**
 * Interface AddressInterface for views.
 */
interface AddressInterface
{
    /**
     * Get id
     *
     * @return string Id
     */
    public function getId();

    /**
     * Get Address
     *
     * @return mixed Address
     */
    public function getAddress();

    /**
     * Get AddressMore
     *
     * @return mixed AddressMore
     */
    public function getAddressMore();

    /**
     * Get Comments
     *
     * @return string Comments
     */
    public function getComments();

    /**
     * Get Mobile
     *
     * @return mixed Mobile
     */
    public function getMobile();

    /**
     * Get Name
     *
     * @return mixed Name
     */
    public function getName();

    /**
     * Get Phone
     *
     * @return mixed Phone
     */
    public function getPhone();

    /**
     * Get RecipientName
     *
     * @return string RecipientName
     */
    public function getRecipientName();

    /**
     * Get RecipientSurname
     *
     * @return mixed RecipientSurname
     */
    public function getRecipientSurname();

    /**
     * Get City
     *
     * @return string City
     */
    public function getCity();

    /**
     * Get Postalcode
     *
     * @return string Postalcode
     */
    public function getPostalcode();

    /**
     * Return created_at value
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Return updated_at value
     *
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * Get if entity is enabled
     *
     * @return boolean Enabled
     */
    public function isEnabled();
}
