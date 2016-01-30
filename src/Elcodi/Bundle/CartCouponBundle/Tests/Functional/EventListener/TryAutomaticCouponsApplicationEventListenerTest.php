<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener;

use DateTime;

use Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener\Abstracts\AbstractCartCouponEventListenerTest;
use Elcodi\Component\Coupon\ElcodiCouponTypes;

/**
 * Class TryAutomaticCouponsApplicationEventListenerTest.
 */
class TryAutomaticCouponsApplicationEventListenerTest extends AbstractCartCouponEventListenerTest
{
    /**
     * Test tryAutomaticCoupons.
     */
    public function testTryAutomaticCoupons()
    {
        $couponAutomatic = $this
            ->getFactory('coupon')
            ->create()
            ->setCode('automatic')
            ->setName('50 percent discount')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(50)
            ->setCount(100)
            ->setEnabled(true)
            ->setEnforcement(ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC)
            ->setValidFrom(new DateTime())
            ->setValidTo(new DateTime('next month'));
        $this->flush($couponAutomatic);

        $cart = $this->getLoadedCart(2);

        $this->assertEquals(1500, $cart
            ->getAmount()
            ->getAmount()
        );
    }
}
