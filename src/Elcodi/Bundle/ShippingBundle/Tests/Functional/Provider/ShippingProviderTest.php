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

namespace Elcodi\Bundle\ShippingBundle\Tests\Functional\Provider;

use Elcodi\Bundle\ShippingBundle\Tests\Functional\Provider\Abstracts\AbstractProviderTest;

/**
 * Class ShippingProviderTest
 */
class ShippingProviderTest extends AbstractProviderTest
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
        return [
            'elcodi.core.shipping.provider.shipping_provider',
            'elcodi.shipping_provider',
        ];
    }

    /**
     * Test getValidCarrierRangesFromCart
     */
    public function testGetValidCarrierRangesFromCart()
    {
        $order = $this->createShippingEnvironment(2, 1);

        $carriers = $this
            ->get('elcodi.shipping_provider')
            ->getValidCarrierRangesFromCart($order);

        $this->assertCount(1, $carriers);
        $carrier = reset($carriers);
        $this->assertEquals(700, $carrier->getPrice()->getAmount());
    }

    /**
     * Test getValidCarrierRangesFromCart same zone
     */
    public function testGetValidCarrierRangesFromCartSameZone()
    {
        $order = $this->createShippingEnvironment(2, 2);

        $carriers = $this
            ->get('elcodi.shipping_provider')
            ->getValidCarrierRangesFromCart($order);

        $this->assertCount(1, $carriers);
        $carrier = reset($carriers);
        $this->assertEquals(500, $carrier->getPrice()->getAmount());
    }

    /**
     * Test getAllCarrierRangesFromOrder
     */
    public function testGetAllCarrierRangesFromOrder()
    {
        $order = $this->createShippingEnvironment(2, 1);

        $carriers = $this
            ->get('elcodi.shipping_provider')
            ->getAllCarrierRangesFromOrder($order);

        $this->assertCount(3, $carriers);
    }

    /**
     * Test getAllCarrierRangesFromOrder same zone
     */
    public function testGetAllCarrierRangesFromOrderSameZone()
    {
        $order = $this->createShippingEnvironment(2, 2);

        $carriers = $this
            ->get('elcodi.shipping_provider')
            ->getAllCarrierRangesFromOrder($order);

        $this->assertCount(1, $carriers);
    }
}
