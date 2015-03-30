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

namespace Elcodi\Bundle\ShippingBundle\Tests\Functional\Provider;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class ShippingProviderTest
 */
class ShippingRangeProviderTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiShippingBundle',
            'ElcodiCurrencyBundle',
            'ElcodiGeoBundle',
            'ElcodiTaxBundle',
        ];
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return ['elcodi.provider.shipping_range'];
    }

    /**
     * Test provideShippingBaseRangesSatisfiedWithOrder
     */
    public function testProvideCarrierRangesSatisfiedWithOrder()
    {
        $cart = $this->createShippingEnvironment(2, 1);

        $carriers = $this
            ->get('elcodi.provider.shipping_range')
            ->getAllShippingRangesSatisfiedWithCart($cart);

        $this->assertCount(3, $carriers);
    }

    /**
     * Test getAllShippingRangesSatisfiedWithCart with same zone
     */
    public function testGetAllShippingRangesSatisfiedWithCartSameZone()
    {
        $cart = $this->createShippingEnvironment(2, 2);

        $carriers = $this
            ->get('elcodi.provider.shipping_range')
            ->getAllShippingRangesSatisfiedWithCart($cart);

        $this->assertCount(1, $carriers);
    }

    /**
     * Test testGetValidShippingRangesSatisfiedWithCart
     */
    public function testGetValidShippingRangesSatisfiedWithCart()
    {
        $cart = $this->createShippingEnvironment(2, 1);

        $carriers = $this
            ->get('elcodi.provider.shipping_range')
            ->getValidShippingRangesSatisfiedWithCart($cart);

        $this->assertCount(1, $carriers);
        $carrier = reset($carriers);
        $this->assertEquals(700, $carrier->getPrice()->getAmount());
    }

    /**
     * Test testGetValidShippingRangesSatisfiedWithCartSameZone same zone
     */
    public function testGetValidShippingRangesSatisfiedWithCartSameZone()
    {
        $cart = $this->createShippingEnvironment(2, 2);

        $carriers = $this
            ->get('elcodi.provider.shipping_range')
            ->getValidShippingRangesSatisfiedWithCart($cart);

        $this->assertCount(1, $carriers);
        $carrier = reset($carriers);
        $this->assertEquals(500, $carrier->getPrice()->getAmount());
    }

    /**
     * Test getAllCarrierRangesFromOrder
     */
    public function testGetAllCarrierRangesFromOrder()
    {
        $cart = $this->createShippingEnvironment(2, 1);

        $carriers = $this
            ->get('elcodi.provider.shipping_range')
            ->getAllShippingRangesSatisfiedWithCart($cart);

        $this->assertCount(3, $carriers);
    }

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
         * @var AddressInterface $address
         */
        $cart = $this->find('cart', $cartId);
        $address = $this->find('address', $deliveryAddressId);
        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $cart->setDeliveryAddress($address);

        return $cart;
    }
}
