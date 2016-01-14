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
use Elcodi\Component\Coupon\Exception\CouponBelowMinimumPurchaseException;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class ValidateCouponMinimumPriceEventListenerTest.
 */
class ValidateCouponMinimumPriceEventListenerTest extends AbstractCartCouponEventListenerTest
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
            'ElcodiCurrencyBundle',
        ];
    }

    /**
     * Test testValidateCartCouponMinimumPrice.
     *
     * @dataProvider dataValidateCartCouponMinimumPrice
     */
    public function testValidateCartCouponMinimumPrice(
        $price,
        $currency,
        $throwException
    ) {
        $cart = $this->getLoadedCart(2);
        $coupon = $this->getEnabledCoupon(3);
        $coupon->setMinimumPurchase(Money::create(
            $price,
            $this->find('currency', $currency)
        ));

        try {
            $this
                ->get('elcodi.manager.cart_coupon')
                ->addCoupon(
                    $cart,
                    $coupon
                );
        } catch (CouponBelowMinimumPurchaseException $e) {
            if (!$throwException) {
                throw $e;
            }
        }

        /**
         * Clean operations to avoid restart scenario.
         */
        $this
            ->get('elcodi.manager.cart_coupon')
            ->removeCoupon(
                $cart,
                $coupon
            );
    }

    /**
     * Data for testValidateCartCouponMinimumPrice.
     */
    public function dataValidateCartCouponMinimumPrice()
    {
        return [
            [3000, 'USD', false],
            [2999, 'USD', true],
            [2210, 'EUR', false],
            [2200, 'EUR', true],
        ];
    }
}
