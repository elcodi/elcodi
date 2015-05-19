<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class CartEventListenerTest
 */
class CartEventListenerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.event_listener.refresh_coupons',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiUserBundle',
            'ElcodiCurrencyBundle',
            'ElcodiAttributeBundle',
            'ElcodiProductBundle',
            'ElcodiCurrencyBundle',
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
            'ElcodiRuleBundle',
        ];
    }

    /**
     * A cart with an existing valid coupon can load and coupon is still there
     */
    public function testOnCartPreLoadCouponsStillThere()
    {
        $this->loadDefaultTestConfigurationAndReturnRuleId();

        /**
         * @var CartInterface $cart
         */
        $cart = $this->find('cart', 1);

        $cartCouponManager = $this
            ->get('elcodi.manager.cart_coupon');

        $this->assertCount(1, $cartCouponManager->getCoupons($cart));

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $this->assertCount(1, $cartCouponManager->getCoupons($cart));
    }

    /**
     * On a cart with an existing valid coupon, when this becomes invalid and
     * cart is reloaded, then it is removed from the cart
     */
    public function testOnCartPreLoadCouponsRemove()
    {
        $ruleId = $this->loadDefaultTestConfigurationAndReturnRuleId();

        $cartCouponManager = $this
            ->get('elcodi.manager.cart_coupon');

        /**
         * We change rule to false
         *
         * @var RuleInterface $rule
         */
        $rule = $this->find('rule', $ruleId);

        $rule->setExpression('false');

        $this
            ->getObjectManager('rule')
            ->flush();

        /**
         * We load again same Cart and load it
         */
        $cart = $this->find('cart', 1);

        $this->assertCount(1, $cartCouponManager->getCoupons($cart));

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $this->assertCount(0, $cartCouponManager->getCoupons($cart));
    }

    /**
     * Load default test configuration
     *
     * @return integer Rule created id
     */
    public function loadDefaultTestConfigurationAndReturnRuleId()
    {
        /**
         * We assign the coupon to the loaded cart
         *
         * @var CartInterface     $cart
         * @var ProductInterface  $product
         * @var CartLineInterface $cartLine
         * @var CouponInterface   $coupon
         * @var RuleInterface     $rule
         */
        $cart = $this->find('cart', 1);

        $product = $this->find('product', 1);

        $cartLine = $this
            ->getFactory('cartLine')
            ->create()
            ->setProduct($product)
            ->setProductAmount($product->getPrice())
            ->setAmount($product->getPrice())
            ->setQuantity(1)
            ->setCart($cart);

        $cart->addCartLine($cartLine);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $coupon = $this->find('coupon', 1);
        $coupon->setEnabled(true);

        $rule = $this
            ->get('elcodi.factory.rule')
            ->create()
            ->setName('rule')
            ->setExpression('true');

        $this
            ->get('elcodi.manager.cart_coupon')
            ->addCoupon(
                $cart,
                $coupon
            );

        $coupon->setRule($rule);

        $this
            ->getObjectManager('rule')
            ->persist($rule);

        $this
            ->getObjectManager('rule')
            ->flush($rule);

        $this
            ->getObjectManager('coupon')
            ->persist($coupon);

        $this
            ->getObjectManager('coupon')
            ->flush($coupon);

        $ruleId = $rule->getId();

        /**
         * We clear all the Doctrine cache to simulate a new Request
         */
        $this
            ->getObjectManager('cart')
            ->clear();

        return $ruleId;
    }
}
