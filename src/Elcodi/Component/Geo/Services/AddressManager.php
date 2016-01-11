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

namespace Elcodi\Component\Geo\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\EventDispatcher\AddressEventDispatcher;

/**
 * Class AddressManager.
 */
class AddressManager
{
    /**
     * @var ObjectManager
     *
     * Address object manager
     */
    private $addressObjectManager;

    /**
     * @var AddressEventDispatcher
     *
     * Address event dispatcher
     */
    private $addressEventDispatcher;

    /**
     * Builds an address manager.
     *
     * @param ObjectManager          $addressObjectManager   An address object
     *                                                       manager
     * @param AddressEventDispatcher $addressEventDispatcher An address event
     *                                                       dispatcher
     */
    public function __construct(
        ObjectManager $addressObjectManager,
        AddressEventDispatcher $addressEventDispatcher
    ) {
        $this->addressObjectManager = $addressObjectManager;
        $this->addressEventDispatcher = $addressEventDispatcher;
    }

    /**
     * Saves an address making a copy in case it was already persisted. Then
     * returns the saved address.
     *
     * @param AddressInterface $address The address to save
     *
     * @return AddressInterface saved address.
     */
    public function saveAddress(AddressInterface $address)
    {
        if ($address->getId()) {
            $addressToSave = clone $address;
            $addressToSave->setId(null);

            $this->addressObjectManager->refresh($address);
            $this->addressObjectManager->persist($addressToSave);
            $this->addressObjectManager->flush($addressToSave);

            $this->addressEventDispatcher->dispatchAddressOnCloneEvent(
                $address,
                $addressToSave
            );

            return $addressToSave;
        }

        $this
            ->addressObjectManager
            ->flush($address);

        return $address;
    }
}
