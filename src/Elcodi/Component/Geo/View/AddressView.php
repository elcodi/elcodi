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

namespace Elcodi\Component\Geo\View;

use DateTime;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class AddressView.
 */
class AddressView
{
    /**
     * @var LocationProviderAdapterInterface
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
     * @param AddressInterface                 $address          The address to
     *                                                           convert to a view.
     * @param LocationProviderAdapterInterface $locationProvider A location provider
     */
    public function __construct(
        AddressInterface $address,
        LocationProviderAdapterInterface $locationProvider
    ) {
        $this->address = $address;
        $this->locationProvider = $locationProvider;
    }

    /**
     * Get id.
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
     * Get Address.
     *
     * @return string Address
     */
    public function getAddress()
    {
        return $this
            ->address
            ->getAddress();
    }

    /**
     * Get AddressMore.
     *
     * @return string AddressMore
     */
    public function getAddressMore()
    {
        return $this
            ->address
            ->getAddressMore();
    }

    /**
     * Get Comments.
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
     * Get Mobile.
     *
     * @return string Mobile
     */
    public function getMobile()
    {
        return $this
            ->address
            ->getMobile();
    }

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this
            ->address
            ->getName();
    }

    /**
     * Get Phone.
     *
     * @return string Phone
     */
    public function getPhone()
    {
        return $this
            ->address
            ->getPhone();
    }

    /**
     * Get RecipientName.
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
     * Get RecipientSurname.
     *
     * @return string RecipientSurname
     */
    public function getRecipientSurname()
    {
        return $this
            ->address
            ->getRecipientSurname();
    }

    /**
     * Get City.
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
     * Get Postalcode.
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
     * Return created_at value.
     *
     * @return DateTime Created at
     */
    public function getCreatedAt()
    {
        return $this
            ->address
            ->getCreatedAt();
    }

    /**
     * Return updated_at value.
     *
     * @return DateTime Updated at
     */
    public function getUpdatedAt()
    {
        return $this
            ->address
            ->getUpdatedAt();
    }

    /**
     * Get if entity is enabled.
     *
     * @return bool Enabled
     */
    public function isEnabled()
    {
        return $this
            ->address
            ->isEnabled();
    }

    /**
     * Gets the country info.
     *
     * @return LocationData|null Country info
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

        return null;
    }

    /**
     * Get the street name.
     *
     * @return string Street name
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
     * @return LocationData|null
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

        return null;
    }

    /**
     * Gets the address hierarchy.
     *
     * @param AddressInterface $address
     *
     * @return LocationData[] Addres hierarchy
     */
    private function getAddressHierarchy(AddressInterface $address)
    {
        return $this
            ->locationProvider
            ->getHierarchy($address->getCity());
    }
}
