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

namespace Elcodi\CartCouponBundle\Tests\Functional\EventListener;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CoreBundle\Tests\Functional\WebTestCase;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\RuleBundle\Entity\Interfaces\ExpressionInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;

/**
 * Class CartEventListenerTest
 */
class CartEventListenerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
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
            ->container
            ->get('elcodi.cart_coupon_manager');

        /**
         * We change rule to false
         */
        $rule = $this
            ->container
            ->get('elcodi.repository.rule')
            ->find($ruleId);

        $expressionFalse = $this
            ->container
            ->get('elcodi.factory.expression')
            ->create()
            ->setExpression('false');

        $rule->setExpression($expressionFalse);
        $this
            ->getManager('elcodi.core.rule.entity.rule.class')
            ->flush();

        /**
         * We load again same Cart and load it
         */
        $cart = $this
            ->container
            ->get('elcodi.repository.cart')
            ->find(1);

        $this->assertCount(1, $cartCouponManager->getCoupons($cart));

        $this
            ->container
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
            ->container
            ->get('elcodi.cart_coupon_manager');

        /**
         * We load again same Cart and load it
         */
        $cart = $this
            ->container
            ->get('elcodi.repository.cart')
            ->find(1);

        $this
            ->container
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
        $cart = $this
            ->container
            ->get('elcodi.repository.cart')
            ->find(1);

        $coupon = $this
            ->container
            ->get('elcodi.repository.coupon')
            ->find(1);

        $expressionTrue = $this
            ->container
            ->get('elcodi.factory.expression')
            ->create()
            ->setExpression('true');

        $rule = $this
            ->container
            ->get('elcodi.factory.rule')
            ->create()
            ->setName(microtime())
            ->setCode(microtime())
            ->setExpression($expressionTrue);

        $this
            ->container
            ->get('elcodi.object_manager.rule')
            ->persist($rule);

        $coupon->addRule($rule);

        $cartCouponManager = $this
            ->container
            ->get('elcodi.cart_coupon_manager');

        $cartCouponManager->addCoupon(
            $cart,
            $coupon
        );
        $ruleId = $rule->getId();

        /**
         * We clear all the Doctrine cache to simulate a new Request
         */
        $this
            ->getManager('elcodi.core.cart.entity.cart.class')
            ->clear();

        return $ruleId;
    }
}
