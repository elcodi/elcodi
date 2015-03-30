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

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Rule\Services\Interfaces\RuleManagerInterface;

/**
 * Class CouponRuleManager
 */
class CartCouponRuleManager
{
    /**
     * @var RuleManagerInterface
     *
     * Rule manager
     */
    protected $ruleManager;

    /**
     * Construct method
     *
     * @param RuleManagerInterface $ruleManager Rule manager
     */
    public function __construct(RuleManagerInterface $ruleManager)
    {
        $this->ruleManager = $ruleManager;
    }

    /**
     * Checks if given Coupon is valid. To determine its validity, this service
     * will evaluate all rules if there are any.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return boolean Coupon is valid
     */
    public function checkCouponValidity(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $rule = $coupon->getRule();

        if (null === $rule) {
            return true;
        }

        try {
            return $this
                ->ruleManager
                ->evaluate(
                    $rule,
                    [
                        'cart'   => $cart,
                        'coupon' => $coupon,
                    ]
                );
        } catch (\Exception $e) {
            // Maybe log something in case of exception?
        }

        return false;
    }
}
