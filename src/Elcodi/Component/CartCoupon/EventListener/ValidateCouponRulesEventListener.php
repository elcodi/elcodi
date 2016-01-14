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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnCheckEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponRuleValidator;

/**
 * Class ValidateCouponRulesEventListener.
 */
final class ValidateCouponRulesEventListener
{
    /**
     * @var CartCouponRuleValidator
     *
     * CartCoupon Rule validators
     */
    private $cartCouponRuleValidator;

    /**
     * Construct method.
     *
     * @param CartCouponRuleValidator $cartCouponRuleValidator Validator for cart coupon rules
     */
    public function __construct(CartCouponRuleValidator $cartCouponRuleValidator)
    {
        $this->cartCouponRuleValidator = $cartCouponRuleValidator;
    }

    /**
     * Check for the rules required by the coupon.
     *
     * @param CartCouponOnCheckEvent $event Event
     */
    public function validateCartCouponRules(CartCouponOnCheckEvent $event)
    {
        $this
            ->cartCouponRuleValidator
            ->validateCartCouponRules(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
