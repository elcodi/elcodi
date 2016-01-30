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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\Applicator;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class MxNCartCouponApplicatorTest.
 */
class MxNCartCouponApplicatorTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
            'ElcodiProductBundle',
            'ElcodiCurrencyBundle',
        ];
    }

    /**
     * Test getCouponAbsoluteValue.
     *
     * @dataProvider dataGetCouponAbsoluteValue
     */
    public function testGetCouponAbsoluteValue(
        $value,
        $result
    ) {
        $this->reloadScenario();

        $cart = $this->find('cart', 2);
        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $cart,
                $this->find('product', 3),
                4
            );

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $cart,
                $this->find('product_variant', 3),
                2
            );

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $cart,
                $this->find('product_pack', 1),
                3
            );

        $coupon = $this
            ->getRepository('coupon')
            ->findOneBy(
                ['code' => '2x1category1']
            );

        $coupon->setValue($value);
        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );

        $this->assertEquals(
            $result,
            $cart->getAmount()->getAmount()
        );
    }

    /**
     * Data for testGetCouponAbsoluteValue.
     */
    public function dataGetCouponAbsoluteValue()
    {
        return [

            // Specific scenarios
            ['2x1', 15000],
            ['2x1:m(1)&c(2)&p(3)', 21500],
            ['2x1:m(1)&c(2)&p(3):P', 23000],
            ['2x1:m(1)&c(2)&p(3):V', 23500],
            ['2x1:m(1)&c(2)&p(3):K', 25000],
            ['2x1:p(1):P', 24000],
            ['2x1:p(1):K', 20000],
            ['2x1:c(1)', 25000],
            ['2x1:c(2)', 15500],
            ['3x2:c(2)', 19000],
            ['10x1:c(2)', 9500],
            ['4x3:c(2)', 24000],
            ['2x1::V', 23500],

            // Group scenarios (with G modifier)
            ['2x1:m(1)&c(2)&p(3):G', 22000],
            ['2x1:m(1)&c(2)&p(3):PG', 23000],
            ['2x1:m(1)&c(2)&p(3):VG', 23500],
            ['2x1:m(1)&c(2)&p(3):KG', 25000],
            ['2x1:p(1):PG', 24000],
            ['2x1:p(1):KG', 20000],
            ['2x1:c(1):G', 25000],
            ['2x1:c(2):G', 20000],
            ['3x2:c(2):G', 22000],
            ['10x1:c(2):G', 11000],
            ['10x2:c(2):G', 16000],
            ['10x2:c(2):VG', 23500],
            ['2x1::VG', 23500],
        ];
    }
}
