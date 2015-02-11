<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\CartCoupon\EventListener;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\CartCoupon\EventDispatcher\OrderCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;
use Elcodi\Component\CartCoupon\Services\OrderCouponManager;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

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
     * @var OrderCouponManager
     *
     * OrderCoupon manager
     */
    protected $orderCouponManager;

    /**
     * @var ObjectManager
     *
     * OrderCoupon object manager
     */
    protected $orderCouponObjectManager;

    /**
     * construct method
     *
     * @param OrderCouponEventDispatcher $orderCouponEventDispatcher OrderCouponEventDispatcher
     * @param CartCouponManager          $cartCouponManager          CartCoupon manager
     * @param OrderCouponManager         $orderCouponManager         OrderCoupon manager
     * @param ObjectManager              $orderCouponObjectManager   OrderCoupon Object Manager
     */
    public function __construct(
        OrderCouponEventDispatcher $orderCouponEventDispatcher,
        CartCouponManager $cartCouponManager,
        OrderCouponManager $orderCouponManager,
        ObjectManager $orderCouponObjectManager
    ) {
        $this->orderCouponEventDispatcher = $orderCouponEventDispatcher;
        $this->cartCouponManager = $cartCouponManager;
        $this->orderCouponManager = $orderCouponManager;
        $this->orderCouponObjectManager = $orderCouponObjectManager;
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
        $coupons = $this->cartCouponManager->getCoupons($cart);

        if ($coupons->isEmpty()) {
            return;
        }

        /**
         * Before applying Coupons to Order, we should remove old references
         * if exist. Otherwise,
         */
        $this->truncateOrderCoupons($order);

        /**
         * An event is dispatched for each convertible coupon
         */
        $coupons->map(function (CouponInterface $coupon) use ($order) {

            $this
                ->orderCouponEventDispatcher
                ->dispatchOrderCouponOnApplyEvent(
                    $order,
                    $coupon
                );
        });
    }

    /**
     * Purge existing OrderCoupons
     *
     * @param OrderInterface $order Order where to delete all coupons
     *
     * @return $this Self object
     */
    protected function truncateOrderCoupons(OrderInterface $order)
    {
        $orderCoupons = $this
            ->orderCouponManager
            ->getOrderCoupons($order);

        if ($orderCoupons instanceof Collection) {
            foreach ($orderCoupons as $orderCoupon) {
                $this
                    ->orderCouponObjectManager
                    ->remove($orderCoupon);
            }

            $this
                ->orderCouponObjectManager
                ->flush($orderCoupons->toArray());
        }

        return $this;
    }
}
