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
 * Class CartCouponRulesEventListenerTest
 */
class CartCouponRulesEventListenerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart_coupon.event_listener.cart_coupon_rules'
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
     * Tests coupon rules when all rules validate
     *
     * @dataProvider dataOnCartCouponApplyValidate
     */
    public function testOnCartCouponApplyValidate($expressions, $couponsNumber)
    {
        /**
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

        if (!is_array($expressions)) {

            $expressions = array($expressions);
        }

        foreach ($expressions as $expression) {

            $expression = $this
                ->container
                ->get('elcodi.factory.expression')
                ->create()
                ->setExpression($expression);

            $rule = $this
                ->container
                ->get('elcodi.factory.rule')
                ->create()
                ->setName(microtime())
                ->setCode(microtime())
                ->setExpression($expression);

            $this
                ->container
                ->get('elcodi.object_manager.rule')
                ->persist($rule);

            $coupon->addRule($rule);
        }

        $cartCouponManager = $this
            ->container
            ->get('elcodi.cart_coupon_manager');

        $cartCouponManager->addCoupon(
            $cart,
            $coupon
        );

        $cartCoupons = $cartCouponManager->getCoupons(
            $cart,
            $coupon
        );

        $this->assertCount($couponsNumber, $cartCoupons);
    }

    /**
     * Data for testOnCartCouponApplyValidate
     */
    public function dataOnCartCouponApplyValidate()
    {
        return [
            ['true == true', 1],
            ['cart.getId() == 1', 1],
            ['coupon.getId() == 1', 1],
            ['true == false', 0],
            ['null', 0],
            ['false', 0],
            ['true', 1],
            ['cart.getId() == 2', 0],
            ['coupon.getId() == 2', 0],
            [['true == true', '1 == 1'], 1],
            [['cart.getId() == 1', '1 == 1'], 1],
            [['cart.getId() == 1', 'cart.getId() == coupon.getId()'], 1],
            [['true == false', '1 == 1'], 0],
            [['cart.getId() == 1', '1 == 2'], 0],
            [['cart.getId() == 3', 'cart.getId() != coupon.getId()'], 0],
        ];
    }
}
