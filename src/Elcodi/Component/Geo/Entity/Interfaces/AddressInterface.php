<?php

/*
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

namespace Elcodi\Component\Geo\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Address Interface
 */
interface AddressInterface extends DateTimeInterface, EnabledInterface
{
    /**
     * Set id
     *
     * @param string $id Id
     *
     * @return $this Self object
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return string Id
     */
    public function getId();

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
     * Sets City
     *
     * @param CityInterface $city City
     *
     * @return $this self Object
     */
    public function setCity(CityInterface $city);

    /**
     * Get City
     *
     * @return CityInterface City
     */
    public function getCity();

    /**
     * Sets Postalcode
     *
     * @param PostalCodeInterface $postalCode Postalcode
     *
     * @return $this self Object
     */
    public function setPostalcode(PostalCodeInterface $postalCode);

    /**
     * Get Postalcode
     *
     * @return PostalCodeInterface Postalcode
     */
    public function getPostalcode();
}
