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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class MakeCouponUsedEventListenerTest
 */
class MakeCouponUsedEventListenerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
        ];
    }

    /**
     * Test update usage field in Coupon
     */
    public function testUpdateUsage()
    {
        /**
         * @var CartInterface   $cart
         * @var CouponInterface $coupon
         * @var ProductInterface $product
         */
        $cart = $this->find('cart', 2);
        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $coupon = $this->find('coupon', 1);
        $this->assertEquals(0, $coupon->getUsed());
        $coupon->setEnabled(true);
        $this->flush($coupon);

        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $this
            ->get('elcodi.transformer.cart_order')
            ->createOrderFromCart($cart);

        $this->assertEquals(1, $coupon->getUsed());
    }
}
