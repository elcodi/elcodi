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

namespace Elcodi\CartCouponBundle\EventListener;

use Doctrine\Common\Collections\Collection;

use Elcodi\CartBundle\Event\OrderOnCreatedEvent;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CartCouponBundle\EventDispatcher\OrderCouponEventDispatcher;
use Elcodi\CartCouponBundle\Services\CartCouponManager;

use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;

/**
 * Class OrderEventListener
 */
class OrderEventListener
{
    /**
     * @var OrderCouponEventDispatcher
     *
     * orderCouponEventDispatcher
     */
    protected $orderCouponEventDispatcher;

    /**
     * @var CartCouponManager
     *
     * CartCoupon manager
     */
    protected $cartCouponManager;

    /**
     * construct method
     *
     * @param OrderCouponEventDispatcher $orderCouponEventDispatcher OrderCouponEventDispatcher
     * @param CartCouponManager          $cartCouponManager          CartCoupon manager
     */
    public function __construct(
        OrderCouponEventDispatcher $orderCouponEventDispatcher,
        CartCouponManager $cartCouponManager
    )
    {
        $this->orderCouponEventDispatcher = $orderCouponEventDispatcher;
        $this->cartCouponManager = $cartCouponManager;
    }

    /**
     * A new Order has been created.
     *
     * This method adds Coupon logic in this transformation
     *
     * @param OrderOnCreatedEvent $orderOnCreatedEvent OrderOnCreated Event
     */
    public function onOrderOnCreatedEvent(OrderOnCreatedEvent $orderOnCreatedEvent)
    {
        $order = $orderOnCreatedEvent->getOrder();
        $cart = $orderOnCreatedEvent->getCart();
        $cartCouponAmount = $cart->getCouponAmount();

        if ($cartCouponAmount instanceof MoneyInterface) {
            $order->setCouponAmount($cartCouponAmount);
        }

        /**
         * @var Collection $coupons
         */
        $coupons = $this->cartCouponManager->getCartCoupons($cart);

        if ($coupons->isEmpty()) {
            return;
        }

        $coupons->map(function (CartCouponInterface $cartCoupon) use ($order) {

            $coupon = $cartCoupon->getCoupon();
            $this
                ->orderCouponEventDispatcher
                ->dispatchOrderCouponOnApplyEvent(
                    $order,
                    $coupon
                );
        });
    }
}
