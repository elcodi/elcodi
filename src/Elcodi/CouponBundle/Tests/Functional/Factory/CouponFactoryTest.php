<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CouponBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class CouponFactoryTest
 */
class CouponFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.coupon.factory.coupon',
            'elcodi.factory.coupon',
        ];
    }

    /**
     * Test coupon factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.coupon.entity.coupon.class'),
            $this->container->get('elcodi.core.coupon.entity.coupon.instance')
        );
    }

    /**
     * Test coupon factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.coupon.entity.coupon.class'),
            $this->container->get('elcodi.entity.coupon.instance')
        );
    }
}
