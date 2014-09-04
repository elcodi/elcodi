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

namespace Elcodi\Bundle\CouponBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Tests CouponManager class
 */
class CouponManagerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return array Load schema
     */
    protected function loadSchema()
    {
        return false;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.coupon.service.coupon_manager',
            'elcodi.coupon_manager',
        ];
    }
}
