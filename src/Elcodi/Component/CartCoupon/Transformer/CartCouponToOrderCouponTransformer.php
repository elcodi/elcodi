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

namespace Elcodi\Component\CartCoupon\Transformer;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\EventDispatcher\OrderCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;
use Elcodi\Component\CartCoupon\Services\OrderCouponTruncator;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Class CartCouponToOrderCouponTransformer.
 *
 * API methods:
 *
 * * createOrderCouponsByCartCoupons(CartInterface, OrderInterface)
 *
 * @api
 */
class CartCouponToOrderCouponTransformer
{
    /**
     * @var CartCouponManager
     *
     * CartCoupon manager
     */
    private $cartCouponManager;

    /**
     * @var OrderCouponTruncator
     *
     * OrderCoupon truncator
     */
    private $orderCouponTruncator;

    /**
     * @var OrderCouponEventDispatcher
     *
     * OrderCoupon event dispatcher
     */
    private $orderCouponEventDispatcher;

    /**
     * Construct.
     *
     * @param CartCouponManager          $cartCouponManager          CartCoupon manager
     * @param OrderCouponTruncator       $orderCouponTruncator       OrderCoupon truncator
     * @param OrderCouponEventDispatcher $orderCouponEventDispatcher OrderCoupon event dispatcher
     */
    public function __construct(
        CartCouponManager $cartCouponManager,
        OrderCouponTruncator $orderCouponTruncator,
        OrderCouponEventDispatcher $orderCouponEventDispatcher
    ) {
        $this->cartCouponManager = $cartCouponManager;
        $this->orderCouponTruncator = $orderCouponTruncator;
        $this->orderCouponEventDispatcher = $orderCouponEventDispatcher;
    }

    /**
     * A new Order has been created.
     *
     * This method adds Coupon logic in this transformation
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     */
    public function createOrderCouponsByCartCoupons(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $cartCouponAmount = $cart->getCouponAmount();

        if ($cartCouponAmount instanceof MoneyInterface) {
            $order->setCouponAmount($cartCouponAmount);
        }

        /**
         * @var CouponInterface $coupons
         */
        $coupons = $this
            ->cartCouponManager
            ->getCoupons($cart);

        if (empty($coupons)) {
            return;
        }

        /**
         * Before applying Coupons to Order, we should remove old references
         * if exist.
         */
        $this
            ->orderCouponTruncator
            ->truncateOrderCoupons($order);

        /**
         * An event is dispatched for each convertible coupon.
         */
        foreach ($coupons as $coupon) {
            $this
                ->orderCouponEventDispatcher
                ->dispatchOrderCouponOnApplyEvent(
                    $order,
                    $coupon
                );
        }
    }
}
