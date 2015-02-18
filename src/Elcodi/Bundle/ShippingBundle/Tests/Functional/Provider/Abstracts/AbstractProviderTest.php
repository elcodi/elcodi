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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ShippingBundle\Tests\Functional\Provider\Abstracts;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class AbstractProviderTest
 */
abstract class AbstractProviderTest extends WebTestCase
{
    /**
     * Create environment to test and return Order generated
     *
     * @param integer $cartId            Cart id
     * @param integer $deliveryAddressId DeliveryAddress id
     *
     * @return OrderInterface Order generated
     */
    protected function createShippingEnvironment($cartId, $deliveryAddressId)
    {
        /**
         * @var CartInterface $cart - Considering 22.18 euros, 600g
         * @var OrderInterface $order
         * @var AddressInterface $address
         */
        $cart = $this->find('cart', $cartId);
        $address = $this->find('address', $deliveryAddressId);
        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $order = $this
            ->get('elcodi.transformer.cart_order')
            ->createOrderFromCart($cart);

        $order->setDeliveryAddress($address);

        return $order;
    }
}
