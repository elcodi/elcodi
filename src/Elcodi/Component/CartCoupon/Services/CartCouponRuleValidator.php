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

namespace Elcodi\Component\CartCoupon\Services;

use Exception;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Exception\CouponRulesNotValidateException;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Rule\Services\Interfaces\RuleManagerInterface;

/**
 * Class CartCouponRuleValidator.
 *
 * API methods:
 *
 * * validateCartCouponRules(CartInterface, CouponInterface)
 *
 * @api
 */
class CartCouponRuleValidator
{
    /**
     * @var RuleManagerInterface
     *
     * Rule manager
     */
    private $ruleManager;

    /**
     * Construct method.
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
     * @throws CouponRulesNotValidateException Rules not valid
     */
    public function validateCartCouponRules(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $rule = $coupon->getRule();

        if (null === $rule) {
            return;
        }

        try {
            $isValid = $this
                ->ruleManager
                ->evaluate(
                    $rule,
                    [
                        'cart' => $cart,
                        'coupon' => $coupon,
                    ]
                );

            if (!$isValid) {
                throw new CouponRulesNotValidateException();
            }

            return;
        } catch (Exception $e) {
            // Maybe log something in case of exception?
        }

        throw new CouponRulesNotValidateException();
    }
}
