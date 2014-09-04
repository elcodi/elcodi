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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class CartEventListenerTest
 */
class CartEventListenerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return array Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart_coupon.event_listener.cart'
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiUserBundle',
            'ElcodiCurrencyBundle',
            'ElcodiAttributeBundle',
            'ElcodiProductBundle',
            'ElcodiCurrencyBundle',
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
            'ElcodiRuleBundle',
        );
    }

    /**
     * Tests if a cart with an existing Coupon valid, when this Coupon becomes
     * invalid and Cart is reloaded, then this Coupon is removed from the Cart
     */
    public function testOnCartPreLoadCouponsRemove()
    {
        $ruleId = $this->loadDefaultTestConfigurationAndReturnRuleId();

        $cartCouponManager = $this
            ->get('elcodi.cart_coupon_manager');

        /**
         * We change rule to false
         *
         * @var RuleInterface $rule
         */
        $rule = $this->find('rule', $ruleId);

        $expressionFalse = $this
            ->get('elcodi.factory.expression')
            ->create()
            ->setExpression('false');

        $rule->setExpression($expressionFalse);
        $this
            ->getObjectManager('rule')
            ->flush();

        /**
         * We load again same Cart and load it
         */
        $cart = $this->find('cart', 1);

        $this->assertCount(1, $cartCouponManager->getCoupons($cart));

        $this
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($cart);

        $this->assertCount(0, $cartCouponManager->getCoupons($cart));
    }

    /**
     * Tests if a cart with an existing Coupon valid can load good and Coupon
     * is still there
     */
    public function testOnCartPreLoadCouponsStillThere()
    {
        $this->loadDefaultTestConfigurationAndReturnRuleId();

        $cartCouponManager = $this
            ->get('elcodi.cart_coupon_manager');

        /**
         * We load again same Cart and load it
         */
        $cart = $this->find('cart', 1);

        $this
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($cart);

        $this->assertCount(1, $cartCouponManager->getCoupons($cart));

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
         * @var CartInterface $cart
         * @var CouponInterface $coupon
         * @var ExpressionInterface $expression
         * @var RuleInterface $rule
         */
        $cart = $this->find('cart', 1);
        $coupon = $this->find('coupon', 1);

        $expressionTrue = $this
            ->get('elcodi.factory.expression')
            ->create()
            ->setExpression('true');

        $rule = $this
            ->get('elcodi.factory.rule')
            ->create()
            ->setName(microtime())
            ->setCode(microtime())
            ->setExpression($expressionTrue);

        $this
            ->getObjectManager('rule')
            ->persist($rule);

        $coupon->addRule($rule);

        $this
            ->get('elcodi.cart_coupon_manager')
            ->addCoupon(
                $cart,
                $coupon
            );

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
