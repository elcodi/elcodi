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

namespace Elcodi\Component\Geo\Formatter;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Services\Interfaces\LocationProviderInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

class AddressFormatter
{
    /**
     * @var LocationProviderInterface
     *
     * The location provider interface
     */
    private $locationProvider;

    /**
     * Builds a new address formatter
     *
     * @param LocationProviderInterface $locationProvider A location provider
     */
    public function __construct(
        LocationProviderInterface $locationProvider
    ) {
        $this->locationProvider = $locationProvider;
    }

    /**
     * Formats an address on an array
     *
     * @param AddressInterface $address The address to format
     *
     * @return array
     */
    public function toArray(AddressInterface $address)
    {
        $cityLocationId   = $address->getCity();
        $cityHierarchy    = $this
            ->locationProvider
            ->getHierarchy($cityLocationId);
        $cityHierarchyAsc = array_reverse($cityHierarchy);

        $addressArray = [
            'id'               => $address->getId(),
            'name'             => $address->getName(),
            'recipientName'    => $address->getRecipientName(),
            'recipientSurname' => $address->getRecipientSurname(),
            'address'          => $address->getAddress(),
            'addressMore'      => $address->getAddressMore(),
            'postalCode'       => $address->getPostalcode(),
            'phone'            => $address->getPhone(),
            'mobile'           => $address->getMobile(),
            'comment'          => $address->getComments(),
        ];

        foreach ($cityHierarchyAsc as $cityLocationNode) {
            /**
             * @var LocationData $cityLocationNode
             */
            $addressArray['city'][$cityLocationNode->getType()]
                = $cityLocationNode->getName();
        }

        $addressArray['fullAddress'] =
            $this->buildFullAddressString(
                $address,
                $addressArray['city']
            );

        return $addressArray;
    }

    /**
     * Builds a full address string
     *
     * @param AddressInterface $address       The address
     * @param array            $cityHierarchy The full city hierarchy
     *
     * @return string
     */
    protected function buildFullAddressString(
        AddressInterface $address,
        array $cityHierarchy
    ) {
        $cityString = implode(', ', $cityHierarchy);

        return sprintf(
            '%s %s, %s %s',
            $address->getAddress(),
            $address->getAddressMore(),
            $cityString,
            $address->getPostalcode()
        );
    }
}
