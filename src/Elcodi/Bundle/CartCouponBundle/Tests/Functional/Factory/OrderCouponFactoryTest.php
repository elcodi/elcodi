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
 */

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\Factory;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class OrderCouponFactoryTest
 */
class OrderCouponFactoryTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return false;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart_coupon.factory.order_coupon',
            'elcodi.factory.order_coupon',
        ];
    }
}
