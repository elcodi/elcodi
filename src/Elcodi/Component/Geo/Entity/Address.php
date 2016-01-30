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

namespace Elcodi\Component\Geo\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class Address.
 */
class Address implements AddressInterface
{
    use IdentifiableTrait,DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Recipient name
     */
    protected $recipientName;

    /**
     * @var string
     *
     * Recipient surname
     */
    protected $recipientSurname;

    /**
     * @var string
     *
     * Address
     */
    protected $address;

    /**
     * @var string
     *
     * Address more
     */
    protected $addressMore;

    /**
     * @var string
     *
     * Phone
     */
    protected $phone;

    /**
     * @var string
     *
     * Mobile
     */
    protected $mobile;

    /**
     * @var string
     *
     * Comments
     */
    protected $comments;

    /**
     * @var string
     *
     * City
     */
    protected $city;

    /**
     * @var string
     *
     * Postalcode
     */
    protected $postalCode;

    /**
     * Sets Address.
     *
     * @param string $address Address
     *
     * @return $this Self object
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get Address.
     *
     * @return string Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets AddressMore.
     *
     * @param string $addressMore AddressMore
     *
     * @return $this Self object
     */
    public function setAddressMore($addressMore)
    {
        $this->addressMore = $addressMore;

        return $this;
    }

    /**
     * Get AddressMore.
     *
     * @return string AddressMore
     */
    public function getAddressMore()
    {
        return $this->addressMore;
    }

    /**
     * Sets Comments.
     *
     * @param string $comments Comments
     *
     * @return $this Self object
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get Comments.
     *
     * @return string Comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets Mobile.
     *
     * @param string $mobile Mobile
     *
     * @return $this Self object
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get Mobile.
     *
     * @return string Mobile
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Phone.
     *
     * @param string $phone Phone
     *
     * @return $this Self object
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get Phone.
     *
     * @return string Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets RecipientName.
     *
     * @param string $recipientName RecipientName
     *
     * @return $this Self object
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * Get RecipientName.
     *
     * @return string RecipientName
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * Sets RecipientSurname.
     *
     * @param string $recipientSurname RecipientSurname
     *
     * @return $this Self object
     */
    public function setRecipientSurname($recipientSurname)
    {
        $this->recipientSurname = $recipientSurname;

        return $this;
    }

    /**
     * Get RecipientSurname.
     *
     * @return string RecipientSurname
     */
    public function getRecipientSurname()
    {
        return $this->recipientSurname;
    }

    /**
     * Sets City.
     *
     * @param string $city City
     *
     * @return $this Self object
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City.
     *
     * @return string City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets Postalcode.
     *
     * @param string $postalCode Postalcode
     *
     * @return $this Self object
     */
    public function setPostalcode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get Postalcode.
     *
     * @return string Postalcode
     */
    public function getPostalcode()
    {
        return $this->postalCode;
    }
}
