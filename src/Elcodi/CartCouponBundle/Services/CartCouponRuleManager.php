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

namespace Elcodi\CartCouponBundle\Services;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\RuleBundle\Entity\Interfaces\AbstractRuleInterface;
use Elcodi\RuleBundle\Services\RuleManager;

/**
 * Class CouponRuleManager
 */
class CartCouponRuleManager
{
    /**
     * @var RuleManager
     *
     * Rule manager
     */
    protected $ruleManager;

    /**
     * Construct method
     *
     * @param RuleManager $ruleManager Rule manager
     */
    public function __construct(RuleManager $ruleManager)
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
    )
    {
        $rules = $coupon->getRules();

        return $rules->forAll(function ($_, AbstractRuleInterface $rule) use ($cart, $coupon) {
            return $this->ruleManager->evaluateByRule($rule, [
                'cart'   => $cart,
                'coupon' => $coupon,
            ]);
        });
    }
}
