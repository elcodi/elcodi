<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Coupon\Tests\Event\Abstracts;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Coupon\Event\Abstracts\CouponEvent;

class CouponEventTest extends PHPUnit_Framework_TestCase
{
    public function testGetCoupon()
    {
        $coupon = $this->getMock('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $object = new CouponEvent($coupon);

        $this->assertSame($coupon, $object->getCoupon());
    }
}
