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
use Elcodi\Component\CartCoupon\Services\CartCouponMinimumPriceValidator;

/**
 * Class ValidateCouponMinimumPriceEventListener.
 */
final class ValidateCouponMinimumPriceEventListener
{
    /**
     * @var CartCouponMinimumPriceValidator
     *
     * CartCoupon minimum price validator
     */
    private $cartCouponMinimumPriceValidator;

    /**
     * Construct.
     *
     * @param CartCouponMinimumPriceValidator $cartCouponMinimumPriceValidator CartCoupon minimum price validator
     */
    public function __construct(CartCouponMinimumPriceValidator $cartCouponMinimumPriceValidator)
    {
        $this->cartCouponMinimumPriceValidator = $cartCouponMinimumPriceValidator;
    }

    /**
     * Check if cart meets minimum price requirements for a coupon.
     *
     * @param CartCouponOnCheckEvent $event Event
     */
    public function validateCartCouponMinimumPrice(CartCouponOnCheckEvent $event)
    {
        $this
            ->cartCouponMinimumPriceValidator
            ->validateCartCouponMinimumPrice(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
