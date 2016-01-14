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
use Elcodi\Component\CartCoupon\Services\CartCouponValidator;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;

/**
 * Class ValidateCouponEventListener.
 */
final class ValidateCouponEventListener
{
    /**
     * @var CartCouponValidator
     *
     * CartCoupon validator
     */
    private $cartCouponValidator;

    /**
     * Constructor.
     *
     * @param CartCouponValidator $cartCouponValidator CartCoupon validator
     */
    public function __construct(CartCouponValidator $cartCouponValidator)
    {
        $this->cartCouponValidator = $cartCouponValidator;
    }

    /**
     * Check if cart meets basic requirements for a coupon.
     *
     * @param CartCouponOnCheckEvent $event
     *
     * @throws AbstractCouponException
     */
    public function validateCoupon(CartCouponOnCheckEvent $event)
    {
        $this
            ->cartCouponValidator
            ->validateCoupon(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
