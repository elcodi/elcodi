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

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Exception\CouponAlreadyAppliedException;
use Elcodi\Component\CartCoupon\Services\DuplicatedCouponValidator;

/**
 * Class ValidateCouponDuplicationEventListener.
 */
final class ValidateCouponDuplicationEventListener
{
    /**
     * @var DuplicatedCouponValidator
     *
     * Duplicated coupon validator
     */
    private $duplicatedCouponValidator;

    /**
     * Construct method.
     *
     * @param DuplicatedCouponValidator $duplicatedCouponValidator Duplicated coupon validator
     */
    public function __construct(DuplicatedCouponValidator $duplicatedCouponValidator)
    {
        $this->duplicatedCouponValidator = $duplicatedCouponValidator;
    }

    /**
     * Check if this coupon is already applied to the cart.
     *
     * @param CartCouponOnApplyEvent $event Event
     *
     * @throws CouponAlreadyAppliedException Coupon already applied
     */
    public function validateDuplicatedCoupon(CartCouponOnApplyEvent $event)
    {
        $this
            ->duplicatedCouponValidator
            ->validateDuplicatedCoupon(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
