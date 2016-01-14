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

use Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener\Abstracts\AbstractCartCouponEventListenerTest;
use Elcodi\Component\CartCoupon\Exception\CouponAlreadyAppliedException;

/**
 * Class ValidateCouponDuplicationEventListenerTest.
 */
class ValidateCouponDuplicationEventListenerTest extends AbstractCartCouponEventListenerTest
{
    /**
     * Test validateDuplicatedCoupon.
     */
    public function testValidateDuplicatedCoupon()
    {
        $cart = $this->getLoadedCart(2);
        $coupon = $this->getEnabledCoupon(3);

        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );

        try {
            $this
                ->get('elcodi.manager.cart_coupon')
                ->addCoupon(
                    $cart,
                    $coupon
                );

            $this->fail('CouponAlreadyAppliedException should be fired here');
        } catch (CouponAlreadyAppliedException $e) {
            // Silent pass
        }
    }
}
