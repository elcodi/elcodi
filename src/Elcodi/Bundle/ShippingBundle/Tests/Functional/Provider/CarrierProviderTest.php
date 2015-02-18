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

namespace Elcodi\Bundle\ShippingBundle\Tests\Functional\Provider;

use Elcodi\Bundle\ShippingBundle\Tests\Functional\Provider\Abstracts\AbstractProviderTest;

/**
 * Class CarrierProviderTest
 *
 * @author Pepito <pepito@engonga.com>
 */
class CarrierProviderTest extends AbstractProviderTest
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
        return ['elcodi.provider.carrier'];
    }

    /**
     * Test provideShippingBaseRangesSatisfiedWithOrder
     */
    public function testProvideCarrierRangesSatisfiedWithOrder()
    {
        $order = $this->createShippingEnvironment(2, 1);

        $carriers = $this
            ->get('elcodi.provider.carrier')
            ->provideCarrierRangesSatisfiedWithOrder($order);

        $this->assertCount(3, $carriers);
    }

    /**
     * Test provideCarrierRangesSatisfiedWithOrder with same zone
     */
    public function testProvideCarrierRangesSatisfiedWithOrderSameZone()
    {
        $order = $this->createShippingEnvironment(2, 2);

        $carriers = $this
            ->get('elcodi.provider.carrier')
            ->provideCarrierRangesSatisfiedWithOrder($order);

        $this->assertCount(1, $carriers);
    }
}
