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

namespace Elcodi\GeoBundle\Entity;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\GeoBundle\Entity\Interfaces\AddressInterface;
use Elcodi\GeoBundle\Entity\Interfaces\CountryInterface;

/**
 * Address
 */
class Address extends AbstractEntity implements AddressInterface
{
    use DateTimeTrait, EnabledTrait;

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
     * Postalcode
     */
    protected $postalCode;

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
     * Province
     */
    protected $province;

    /**
     * @var string
     *
     * State
     */
    protected $state;

    /**
     * @var CountryInterface
     *
     * Country
     */
    protected $country;

    /**
     * Sets Address
     *
     * @param string $address Address
     *
     * @return Address Self object
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get Address
     *
     * @return string Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets AddressMore
     *
     * @param string $addressMore AddressMore
     *
     * @return Address Self object
     */
    public function setAddressMore($addressMore)
    {
        $this->addressMore = $addressMore;

        return $this;
    }

    /**
     * Get AddressMore
     *
     * @return string AddressMore
     */
    public function getAddressMore()
    {
        return $this->addressMore;
    }

    /**
     * Sets City
     *
     * @param string $city City
     *
     * @return Address Self object
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City
     *
     * @return string City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets Comments
     *
     * @param string $comments Comments
     *
     * @return Address Self object
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get Comments
     *
     * @return string Comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets Country
     *
     * @param CountryInterface $country Country
     *
     * @return Address Self object
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get Country
     *
     * @return CountryInterface Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets Mobile
     *
     * @param string $mobile Mobile
     *
     * @return Address Self object
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get Mobile
     *
     * @return string Mobile
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return Address Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Phone
     *
     * @param string $phone Phone
     *
     * @return Address Self object
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get Phone
     *
     * @return string Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets PostalCode
     *
     * @param string $postalCode PostalCode
     *
     * @return Address Self object
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get PostalCode
     *
     * @return string PostalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Sets Province
     *
     * @param string $province Province
     *
     * @return Address Self object
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get Province
     *
     * @return string Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Sets RecipientName
     *
     * @param string $recipientName RecipientName
     *
     * @return Address Self object
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * Get RecipientName
     *
     * @return string RecipientName
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * Sets RecipientSurname
     *
     * @param string $recipientSurname RecipientSurname
     *
     * @return Address Self object
     */
    public function setRecipientSurname($recipientSurname)
    {
        $this->recipientSurname = $recipientSurname;

        return $this;
    }

    /**
     * Get RecipientSurname
     *
     * @return string RecipientSurname
     */
    public function getRecipientSurname()
    {
        return $this->recipientSurname;
    }

    /**
     * Sets State
     *
     * @param string $state State
     *
     * @return Address Self object
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get State
     *
     * @return string State
     */
    public function getState()
    {
        return $this->state;
    }
}
