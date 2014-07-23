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

namespace Elcodi\GeoBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

/**
 * Address Interface
 */
interface AddressInterface extends DateTimeInterface, EnabledInterface
{
    /**
     * Sets Address
     *
     * @param mixed $address Address
     *
     * @return AddressInterface Self object
     */
    public function setAddress($address);

    /**
     * Get Address
     *
     * @return mixed Address
     */
    public function getAddress();

    /**
     * Sets AddressMore
     *
     * @param mixed $addressMore AddressMore
     *
     * @return AddressInterface Self object
     */
    public function setAddressMore($addressMore);

    /**
     * Get AddressMore
     *
     * @return mixed AddressMore
     */
    public function getAddressMore();

    /**
     * Sets City
     *
     * @param string $city City
     *
     * @return AddressInterface Self object
     */
    public function setCity($city);

    /**
     * Get City
     *
     * @return string City
     */
    public function getCity();

    /**
     * Sets Comments
     *
     * @param string $comments Comments
     *
     * @return AddressInterface Self object
     */
    public function setComments($comments);

    /**
     * Get Comments
     *
     * @return string Comments
     */
    public function getComments();

    /**
     * Sets Country
     *
     * @param CountryInterface $country Country
     *
     * @return AddressInterface Self object
     */
    public function setCountry($country);

    /**
     * Get Country
     *
     * @return CountryInterface Country
     */
    public function getCountry();

    /**
     * Sets Mobile
     *
     * @param mixed $mobile Mobile
     *
     * @return AddressInterface Self object
     */
    public function setMobile($mobile);

    /**
     * Get Mobile
     *
     * @return mixed Mobile
     */
    public function getMobile();

    /**
     * Sets Name
     *
     * @param mixed $name Name
     *
     * @return AddressInterface Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return mixed Name
     */
    public function getName();

    /**
     * Sets Phone
     *
     * @param mixed $phone Phone
     *
     * @return AddressInterface Self object
     */
    public function setPhone($phone);

    /**
     * Get Phone
     *
     * @return mixed Phone
     */
    public function getPhone();

    /**
     * Sets PostalCode
     *
     * @param mixed $postalCode PostalCode
     *
     * @return AddressInterface Self object
     */
    public function setPostalCode($postalCode);

    /**
     * Get PostalCode
     *
     * @return mixed PostalCode
     */
    public function getPostalCode();

    /**
     * Sets Province
     *
     * @param mixed $province Province
     *
     * @return AddressInterface Self object
     */
    public function setProvince($province);

    /**
     * Get Province
     *
     * @return mixed Province
     */
    public function getProvince();

    /**
     * Sets RecipientName
     *
     * @param string $recipientName RecipientName
     *
     * @return AddressInterface Self object
     */
    public function setRecipientName($recipientName);

    /**
     * Get RecipientName
     *
     * @return string RecipientName
     */
    public function getRecipientName();

    /**
     * Sets RecipientSurname
     *
     * @param mixed $recipientSurname RecipientSurname
     *
     * @return AddressInterface Self object
     */
    public function setRecipientSurname($recipientSurname);

    /**
     * Get RecipientSurname
     *
     * @return mixed RecipientSurname
     */
    public function getRecipientSurname();

    /**
     * Sets State
     *
     * @param mixed $state State
     *
     * @return AddressInterface Self object
     */
    public function setState($state);

    /**
     * Get State
     *
     * @return mixed State
     */
    public function getState();
}
