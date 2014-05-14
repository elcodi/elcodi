<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\CartCouponBundle\EventListener;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartBundle\Event\OrderOnCreatedEvent;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CartCouponBundle\Factory\OrderCouponFactory;
use Elcodi\CartCouponBundle\Services\CartCouponManager;
use Elcodi\CouponBundle\EventDispatcher\CouponEventDispatcher;

/**
 * Class OrderEventListener
 */
class OrderEventListener
{
    /**
     * @var CouponEventDispatcher
     *
     * Coupon Event Dispatcher
     */
    protected $couponEventDispatcher;

    /**
     * @var OrderCouponFactory
     *
     * OrderCouponFactory
     */
    protected $orderCouponFactory;

    /**
     * @var CartCouponManager
     *
     * CartCoupon manager
     */
    protected $cartCouponManager;

    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $manager;

    /**
     * construct method
     *
     * @param CouponEventDispatcher $couponEventDispatcher CouponEventDispatcher
     * @param OrderCouponFactory    $orderCouponFactory    OrderCouponFactory
     * @param CartCouponManager     $cartCouponManager     CartCoupon manager
     * @param ObjectManager         $manager               Manager
     */
    public function __construct(
        CouponEventDispatcher $couponEventDispatcher,
        OrderCouponFactory $orderCouponFactory,
        CartCouponManager  $cartCouponManager,
        ObjectManager $manager
    )
    {
        $this->couponEventDispatcher = $couponEventDispatcher;
        $this->orderCouponFactory = $orderCouponFactory;
        $this->cartCouponManager = $cartCouponManager;
        $this->manager = $manager;
    }

    /**
     * New order has been created from a Cart, so Coupon value should be copied
     * from cart to order.
     *
     * @param OrderOnCreatedEvent $orderOnCreatedEvent OrderOnCreated Event
     *
     * @return OrderEventListener self Object
     */
    public function onOrderOnCreatedEventCouponsValue(OrderOnCreatedEvent $orderOnCreatedEvent)
    {
        $order = $orderOnCreatedEvent->getOrder();
        $cart = $orderOnCreatedEvent->getCart();

        $order->setCouponAmount($cart->getCouponAmount());

        return $this;
    }

    /**
     * All cart coupons should me copied to new generated Order
     *
     * Also, per each applied Coupon, a new CouponUsedEvent should be dispatched
     *
     * @param OrderOnCreatedEvent $orderOnCreatedEvent OrderOnCreated Event
     *
     * @return OrderEventListener self Object
     */
    public function onOrderOnCreatedEventTransferCoupons(OrderOnCreatedEvent $orderOnCreatedEvent)
    {
        $order = $orderOnCreatedEvent->getOrder();
        $cart = $orderOnCreatedEvent->getCart();

        /**
         * @var Collection $coupons
         */
        $coupons = $this->cartCouponManager->getCartCoupons($cart);

        if ($coupons->isEmpty()) {
            return $this;
        }

        $coupons->map(function (CartCouponInterface $cartCoupon) use ($order) {

            $coupon = $cartCoupon->getCoupon();
            $orderCoupon = $this->orderCouponFactory->create();
            $orderCoupon
                ->setOrder($order)
                ->setCoupon($coupon);

            $this->manager->persist($orderCoupon);
            $this->manager->flush($orderCoupon);

            $this->couponEventDispatcher->notifyCouponUsage($coupon);
        });

        return $this;
    }
}
