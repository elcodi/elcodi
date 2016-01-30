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

namespace Elcodi\Bundle\CouponBundle\Tests\Functional\Factory;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Coupon\Entity\Coupon;

/**
 * Class CouponFactoryTest.
 */
class CouponFactoryTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCurrencyBundle',
        ];
    }

    /**
     * Tests that the Coupon object is factored correctly.
     */
    public function testCreateCouponFactory()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.entity.coupon.class'),
            $this->get('elcodi.factory.coupon')->create()
        );
    }

    /**
     * Tests that amounts in the Currency objects are Money value objects.
     */
    public function testCouponPricesAreMoney()
    {
        /**
         * @var $coupon Coupon
         */
        $coupon = $this->get('elcodi.factory.coupon')->create();

        $this->assertInstanceOf(
            'Elcodi\Component\Currency\Entity\Money',
            $coupon->getPrice()
        );

        $this->assertInstanceOf(
            'Elcodi\Component\Currency\Entity\Money',
            $coupon->getAbsolutePrice()
        );

        $this->assertInstanceOf(
            'Elcodi\Component\Currency\Entity\Money',
            $coupon->getMinimumPurchase()
        );
    }
}
