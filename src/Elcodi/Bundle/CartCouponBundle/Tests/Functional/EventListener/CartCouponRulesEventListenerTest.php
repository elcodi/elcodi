<?php

/*
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
 * Class CartCouponRulesEventListenerTest
 */
class CartCouponRulesEventListenerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
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
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
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
        $cart = $this->find('cart', 1);
        $coupon = $this->find('coupon', 1);

        if (!is_array($expressions)) {

            $expressions = array($expressions);
        }

        foreach ($expressions as $expression) {

            $expression = $this
                ->get('elcodi.factory.expression')
                ->create()
                ->setExpression($expression);

            $rule = $this
                ->get('elcodi.factory.rule')
                ->create()
                ->setName(microtime())
                ->setCode(microtime())
                ->setExpression($expression);

            $this
                ->getObjectManager('rule')
                ->persist($rule);

            $coupon->addRule($rule);
        }

        $cartCouponManager = $this->get('elcodi.cart_coupon_manager');

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
