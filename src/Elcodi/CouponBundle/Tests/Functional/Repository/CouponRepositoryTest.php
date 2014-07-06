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

namespace Elcodi\CouponBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class CouponRepositoryTest
 */
class CouponRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.coupon.repository.coupon',
            'elcodi.repository.coupon',
        ];
    }

    /**
     * Test coupon repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.coupon.repository.coupon.class'),
            $this->container->get('elcodi.core.coupon.repository.coupon')
        );
    }

    /**
     * Test coupon repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.coupon.repository.coupon.class'),
            $this->container->get('elcodi.repository.coupon')
        );
    }
}
