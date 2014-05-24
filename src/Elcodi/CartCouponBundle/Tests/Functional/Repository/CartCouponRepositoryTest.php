<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class CartCouponRepositoryTest
 */
class CartCouponRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart_coupon.repository.cart_coupon',
            'elcodi.repository.cart_coupon',
        ];
    }

    /**
     * Test cart_coupon repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.cart_coupon.repository.cart_coupon.class'),
            $this->container->get('elcodi.core.cart_coupon.repository.cart_coupon')
        );
    }

    /**
     * Test cart_coupon repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.cart_coupon.repository.cart_coupon.class'),
            $this->container->get('elcodi.repository.cart_coupon')
        );
    }
}
