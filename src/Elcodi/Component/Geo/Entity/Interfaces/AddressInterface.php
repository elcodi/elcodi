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

namespace Elcodi\Component\Geo\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface AddressInterface.
 */
interface AddressInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface
{
    /**
     * Sets Address.
     *
     * @param string $address Address
     *
     * @return $this Self object
     */
    public function setAddress($address);

    /**
     * Get Address.
     *
     * @return string Address
     */
    public function getAddress();

    /**
     * Sets AddressMore.
     *
     * @param string $addressMore AddressMore
     *
     * @return $this Self object
     */
    public function setAddressMore($addressMore);

    /**
     * Get AddressMore.
     *
     * @return string AddressMore
     */
    public function getAddressMore();

    /**
     * Sets Comments.
     *
     * @param string $comments Comments
     *
     * @return $this Self object
     */
    public function setComments($comments);

    /**
     * Get Comments.
     *
     * @return string Comments
     */
    public function getComments();

    /**
     * Sets Mobile.
     *
     * @param string $mobile Mobile
     *
     * @return $this Self object
     */
    public function setMobile($mobile);

    /**
     * Get Mobile.
     *
     * @return string Mobile
     */
    public function getMobile();

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Phone.
     *
     * @param string $phone Phone
     *
     * @return $this Self object
     */
    public function setPhone($phone);

    /**
     * Get Phone.
     *
     * @return string Phone
     */
    public function getPhone();

    /**
     * Sets RecipientName.
     *
     * @param string $recipientName RecipientName
     *
     * @return $this Self object
     */
    public function setRecipientName($recipientName);

    /**
     * Get RecipientName.
     *
     * @return string RecipientName
     */
    public function getRecipientName();

    /**
     * Sets RecipientSurname.
     *
     * @param string $recipientSurname RecipientSurname
     *
     * @return $this Self object
     */
    public function setRecipientSurname($recipientSurname);

    /**
     * Get RecipientSurname.
     *
     * @return string RecipientSurname
     */
    public function getRecipientSurname();

    /**
     * Sets City.
     *
     * @param string $city City
     *
     * @return $this Self object
     */
    public function setCity($city);

    /**
     * Get City.
     *
     * @return string City
     */
    public function getCity();

    /**
     * Sets Postalcode.
     *
     * @param string $postalCode Postalcode
     *
     * @return $this Self object
     */
    public function setPostalcode($postalCode);

    /**
     * Get Postalcode.
     *
     * @return string Postalcode
     */
    public function getPostalcode();
}
