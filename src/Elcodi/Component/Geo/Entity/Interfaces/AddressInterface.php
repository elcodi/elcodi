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
     * @return self
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
     * @return self
     */
    public function setAddress($address);

    /**
     * Get Address
     *
     * @return string Address
     */
    public function getAddress();

    /**
     * Sets AddressMore
     *
     * @param mixed $addressMore AddressMore
     *
     * @return self
     */
    public function setAddressMore($addressMore);

    /**
     * Get AddressMore
     *
     * @return string AddressMore
     */
    public function getAddressMore();

    /**
     * Sets Comments
     *
     * @param string $comments Comments
     *
     * @return self
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
     * @return self
     */
    public function setMobile($mobile);

    /**
     * Get Mobile
     *
     * @return string Mobile
     */
    public function getMobile();

    /**
     * Sets Name
     *
     * @param mixed $name Name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Phone
     *
     * @param mixed $phone Phone
     *
     * @return self
     */
    public function setPhone($phone);

    /**
     * Get Phone
     *
     * @return string Phone
     */
    public function getPhone();

    /**
     * Sets RecipientName
     *
     * @param string $recipientName RecipientName
     *
     * @return self
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
     * @return self
     */
    public function setRecipientSurname($recipientSurname);

    /**
     * Get RecipientSurname
     *
     * @return string RecipientSurname
     */
    public function getRecipientSurname();

    /**
     * Sets City
     *
     * @param CityInterface $city City
     *
     * @return self
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
     * @return self
     */
    public function setPostalcode(PostalCodeInterface $postalCode);

    /**
     * Get Postalcode
     *
     * @return PostalCodeInterface Postalcode
     */
    public function getPostalcode();
}
