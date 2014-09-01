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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Exception\CouponRulesNotValidateException;
use Elcodi\Component\CartCoupon\Services\CartCouponRuleManager;

/**
 * Class CartCouponRulesEventListener
 */
class CartCouponRulesEventListener
{
    /**
     * @var CartCouponRuleManager
     *
     * CartCoupon Rule managers
     */
    protected $cartCouponRuleManager;

    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event Dispatcher
     */
    protected $cartCouponEventDispatcher;

    /**
     * Construct method
     *
     * @param CartCouponRuleManager     $cartCouponRuleManager     CartCouponRuleManager
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher $cartCouponEventDispatcher
     */
    public function __construct(
        CartCouponRuleManager $cartCouponRuleManager,
        CartCouponEventDispatcher $cartCouponEventDispatcher
    )
    {
        $this->cartCouponRuleManager = $cartCouponRuleManager;
        $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
    }

    /**
     * Applies Coupon in Cart, and flushes it
     *
     * @param CartCouponOnApplyEvent $event Event
     *
     * @throws CouponRulesNotValidateException Invalid rules
     */
    public function onCartCouponApply(CartCouponOnApplyEvent $event)
    {
        $cart = $event->getCart();
        $coupon = $event->getCoupon();

        if (!$this->cartCouponRuleManager->checkCouponValidity($cart, $coupon)) {

            $this
                ->cartCouponEventDispatcher
                ->dispatchCartCouponOnRejectedEvent(
                    $cart,
                    $coupon
                );

            $event->stopPropagation();
        }
    }
}
