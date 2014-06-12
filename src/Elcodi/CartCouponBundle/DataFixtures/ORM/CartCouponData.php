<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;

/**
 * Class CartCouponData
 */
class CartCouponData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Carts
         *
         * @var CartCouponInterface $cartCoupon
         * @var CartInterface       $cart
         * @var CouponInterface     $coupon
         * @var CurrencyInterface   $currency
         */
        $cartCoupon = $this->container->get('elcodi.core.cart_coupon.factory.cart_coupon')->create();
        $cart = $this->getReference('full-cart');
        $coupon = $this->getReference('coupon-percent');
        $currency = $this->getReference('currency-dollar');

        $cartCoupon
            ->setCart($cart)
            ->setCoupon($coupon);

        $cart
            ->setCouponAmount(new Money($coupon->getAbsoluteValue()*100, $currency))
            ->setAmount(new Money(($cart->getAmount()->getAmount() - $coupon->getAbsoluteValue())*100, $currency));

        $manager->persist($cartCoupon);
        $this->addReference('cart-coupon', $cartCoupon);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 6;
    }
}
