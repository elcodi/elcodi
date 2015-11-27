<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class CartCouponRulesEventListenerTest
 */
class CartCouponRulesEventListenerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCouponBundle',
            'ElcodiCartBundle',
        ];
    }

    /**
     * Tests coupon rules when all rules validate
     *
     * @param array   $expressions   One or more expressions, only the last one will be checked
     * @param integer $couponsNumber Number of coupons that should apply
     *
     * @dataProvider dataOnCartCouponApplyValidate
     */
    public function testOnCartCouponApplyValidate(array $expressions, $couponsNumber)
    {
        $this->reloadScenario();

        /**
         * @var CartInterface   $cart
         * @var CouponInterface $coupon
         * @var RuleInterface   $rule
         */
        $cart = $this->find('cart', 2);
        $coupon = $this->find('coupon', 1);

        $coupon
            ->setEnabled(true)
            ->setCount(0);

        foreach ($expressions as $name => $expression) {
            $rule = $this
                ->getFactory('rule')
                ->create()
                ->setName($name)
                ->setExpression($expression);
            $this->flush($rule);
        }

        $coupon->setRule($rule);

        $cartCouponManager = $this->get('elcodi.manager.cart_coupon');
        try {
            $cartCouponManager->addCoupon(
                $cart,
                $coupon
            );
        } catch (AbstractCouponException $e) {
            // Silently pass
        }

        $cartCoupons = $cartCouponManager->getCoupons($cart);

        $this->assertCount($couponsNumber, $cartCoupons);
    }

    /**
     * Data for testOnCartCouponApplyValidate
     */
    public function dataOnCartCouponApplyValidate()
    {
        return [
            [['true == true'], 1],
            [['cart.getId() == 2'], 1],
            [['coupon.getId() == 1'], 1],
            [['true == false'], 0],
            [['null'], 0],
            [['false'], 0],
            [['true'], 1],
            [['cart.getId() == 1'], 0],
            [['coupon.getId() == 2'], 0],
            [['true == true', '1 == 1', 'rule(0) and rule(1)'], 1],
            [['cart.getId() == 2', '1 == 1', 'rule(0) and rule(1)'], 1],
            [['cart.getId() == 2', 'cart.getId() != coupon.getId()', 'rule(0) and rule(1)'], 1],
            [['true == false', '1 == 1', 'rule(0) and rule(1)'], 0],
            [['true == false', '1 == 1', 'rule(0) or rule(1)'], 1],
            [['cart.getId() == 2', '1 == 2', 'rule(0) and rule(1)'], 0],
            [['cart.getId() == 3', 'cart.getId() != coupon.getId()', 'rule(0) and rule(1)'], 0],
            [
                [
                    'few_products' => 'cart.getQuantity() < 5',
                    'low_cost'     => 'cart.getAmount() < 10',
                    'rule("few_products") and rule("low_cost")',
                ],
                1,
            ],
        ];
    }
}
