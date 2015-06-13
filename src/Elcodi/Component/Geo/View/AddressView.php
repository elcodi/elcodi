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

namespace Elcodi\Component\Geo\View;

use DateTime;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Services\Interfaces\LocationProviderInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;
use Elcodi\Component\Geo\View\Interfaces\AddressViewInterface;

/**
 * Class AddressView
 */
class AddressView implements AddressViewInterface
{
    /**
     * @var array
     *
     * The hierarchies already retrieved.
     */
    protected static $hierarchies = [];

    /**
     * @var LocationProviderInterface
     *
     * A location provider interface.
     */
    protected $locationProvider;

    /**
     * @var AddressInterface
     *
     * An address.
     */
    protected $address;

    /**
     * Builds a new view.
     *
     * @param AddressInterface          $address          The address to
     *                                                    convert to a view.
     * @param LocationProviderInterface $locationProvider A location provider
     */
    public function __construct(
        AddressInterface $address,
        LocationProviderInterface $locationProvider
    ) {
        $this->address = $address;
        $this->locationProvider = $locationProvider;
    }

    /**
     * Get id
     *
     * @return string Id
     */
    public function getId()
    {
        return $this
            ->address
            ->getId();
    }

    /**
     * Get Address
     *
     * @return mixed Address
     */
    public function getAddress()
    {
        return $this
            ->address
            ->getAddress();
    }

    /**
     * Get AddressMore
     *
     * @return mixed AddressMore
     */
    public function getAddressMore()
    {
        return $this
            ->address
            ->getAddressMore();
    }

    /**
     * Get Comments
     *
     * @return string Comments
     */
    public function getComments()
    {
        return $this
            ->address
            ->getComments();
    }

    /**
     * Get Mobile
     *
     * @return mixed Mobile
     */
    public function getMobile()
    {
        return $this
            ->address
            ->getMobile();
    }

    /**
     * Get Name
     *
     * @return mixed Name
     */
    public function getName()
    {
        return $this
            ->address
            ->getName();
    }

    /**
     * Get Phone
     *
     * @return mixed Phone
     */
    public function getPhone()
    {
        return $this
            ->address
            ->getPhone();
    }

    /**
     * Get RecipientName
     *
     * @return string RecipientName
     */
    public function getRecipientName()
    {
        return $this
            ->address
            ->getRecipientName();
    }

    /**
     * Get RecipientSurname
     *
     * @return mixed RecipientSurname
     */
    public function getRecipientSurname()
    {
        return $this
            ->address
            ->getRecipientSurname();
    }

    /**
     * Get City
     *
     * @return string City
     */
    public function getCity()
    {
        return $this
            ->address
            ->getCity();
    }

    /**
     * Get Postalcode
     *
     * @return string Postalcode
     */
    public function getPostalcode()
    {
        return $this
            ->address
            ->getPostalcode();
    }

    /**
     * Return created_at value
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this
            ->address
            ->getCreatedAt();
    }

    /**
     * Return updated_at value
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this
            ->address
            ->getUpdatedAt();
    }

    /**
     * Get if entity is enabled
     *
     * @return boolean Enabled
     */
    public function isEnabled()
    {
        return $this
            ->address
            ->isEnabled();
    }

    /**
     * Gets the country info
     *
     * @return LocationData
     */
    public function getCountryInfo()
    {
        $hierarchy = $this->getAddressHierarchy($this->address);

        foreach ($hierarchy as $location) {
            /**
             * @var LocationData $location
             */
            if ('country' == $location->getType()) {
                return $location;
            }
        }
    }

    /**
     * Get the street name.
     *
     * @return string
     */
    public function getStreetName()
    {
        return sprintf(
            '%s %s',
            $this->address->getAddress(),
            $this->address->getAddressMore()
        );
    }

    /**
     * Get the city location info.
     *
     * @return LocationData
     */
    public function getCityInfo()
    {
        $hierarchy = $this->getAddressHierarchy($this->address);

        foreach ($hierarchy as $location) {
            /**
             * @var LocationData $location
             */
            if ('city' == $location->getType()) {
                return $location;
            }
        }
    }

    /**
     * Gets the address hierarchy.
     *
     * @param AddressInterface $address
     *
     * @return LocationData
     */
    private function getAddressHierarchy(
        AddressInterface $address
    ) {
        $city = $address->getCity();

        if (isset(self::$hierarchies[$city])) {
            return self::$hierarchies[$city];
        }

        $hierarchy = $this
            ->locationProvider
            ->getHierarchy($city);

        self::$hierarchies[$city] = $hierarchy;

        return $hierarchy;
    }
}
