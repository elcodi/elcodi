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
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class ValidateCouponRulesEventListenerTest.
 */
class ValidateCouponRulesEventListenerTest extends AbstractCartCouponEventListenerTest
{
    /**
     * Tests coupon rules when all rules validate.
     *
     * @param array $expressions   One or more expressions, only the last one will be checked
     * @param int   $couponsNumber Number of coupons that should apply
     *
     * @dataProvider dataValidateCartCouponRules
     */
    public function testValidateCartCouponRules(array $expressions, $couponsNumber)
    {
        /**
         * @var CartInterface   $cart
         * @var CouponInterface $coupon
         * @var RuleInterface   $rule
         */
        $cart = $this->getLoadedCart(2);
        $coupon = $this
            ->getEnabledCoupon(1)
            ->setCount(0);

        $rules = [];
        foreach ($expressions as $name => $expression) {
            $rule = $this
                ->getFactory('rule')
                ->create()
                ->setName($name)
                ->setExpression($expression);
            $this->flush($rule);
            $rules[] = $rule;
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

        /**
         * Clean operations to avoid restart scenario.
         */
        $coupon->setRule(null);
        $this->getDirector('rule')->remove($rules);
        $this
            ->get('elcodi.manager.cart_coupon')
            ->removeCoupon(
                $cart,
                $coupon
            );
    }

    /**
     * Data for testValidateCartCouponRules.
     */
    public function dataValidateCartCouponRules()
    {
        return [
            [['true == true'], 1],
            [['cart.getId() == 2'], 1],
            [['coupon.getId() == 1'], 1],
            [['null'], 0],
            [['true == false'], 0],
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
                    'few_products' => 'cart.getTotalItemNumber() < 5',
                    'low_cost' => 'cart.getAmount().getAmount() > 2000',
                    'rule("few_products") and rule("low_cost")',
                ],
                1,
            ],
        ];
    }
}
