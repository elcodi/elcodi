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

namespace Elcodi\Bundle\CartCouponBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class CartCouponData
 */
class CartCouponData extends AbstractFixture implements DependentFixtureInterface
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

        $cartCoupon
            ->setCart($cart)
            ->setCoupon($coupon);

        $manager->persist($cartCoupon);
        $this->addReference('cart-coupon', $cartCoupon);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\CartBundle\DataFixtures\ORM\CartData',
            'Elcodi\Bundle\CouponBundle\DataFixtures\ORM\CouponData',
        ];
    }
}
