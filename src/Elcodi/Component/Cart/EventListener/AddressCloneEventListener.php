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

namespace Elcodi\Component\Cart\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Repository\CartRepository;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Event\AddressOnCloneEvent;

/**
 * Class AddressCloneEventListener.
 *
 * These event listener is used when an address is cloned
 *
 * Public methods:
 *
 * * updateCarts
 */
final class AddressCloneEventListener
{
    /**
     * @var CartRepository
     *
     * The cart repository
     */
    private $cartRepository;

    /**
     * @var ObjectManager
     *
     * The cart object manager
     */
    private $cartObjectManager;

    /**
     * Builds an event listener.
     *
     * @param CartRepository $cartRepository
     * @param ObjectManager  $cartObjectManager
     */
    public function __construct(
        CartRepository $cartRepository,
        ObjectManager $cartObjectManager
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartObjectManager = $cartObjectManager;
    }

    /**
     * Updates all the carts with the cloned address.
     *
     * @param AddressOnCloneEvent $event Event
     */
    public function updateCarts(AddressOnCloneEvent $event)
    {
        $originalAddress = $event->getOriginalAddress();
        $clonedAddress = $event->getClonedAddress();
        $carts = $this
            ->cartRepository
            ->findAllCartsWithAddress($originalAddress);

        foreach ($carts as $cart) {
            /**
             * @var CartInterface $cart
             */
            $deliveryAddress = $cart->getDeliveryAddress();
            $billingAddress = $cart->getBillingAddress();

            if (
                $deliveryAddress instanceof AddressInterface
                && $deliveryAddress->getId() == $originalAddress->getId()
            ) {
                $cart->setDeliveryAddress($clonedAddress);
            }

            if (
                $billingAddress instanceof AddressInterface
                && $billingAddress->getId() == $originalAddress->getId()
            ) {
                $cart->setBillingAddress($clonedAddress);
            }

            $this->cartObjectManager->flush($cart);
        }
    }
}
