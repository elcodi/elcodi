<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartCouponBundle\Event\OrderCouponOnApplyEvent;
use Elcodi\CartCouponBundle\Factory\OrderCouponFactory;
use Elcodi\CouponBundle\EventDispatcher\CouponEventDispatcher;

/**
 * Class OrderCouponEventListener
 *
 * This eventListener is subscribed into OpenCoupon events.
 */
class OrderCouponEventListener
{
    /**
     * @var ObjectManager
     *
     * cartCouponObjectManager
     */
    protected $orderCouponObjectManager;

    /**
     * @var CouponEventDispatcher
     *
     * CouponEventDispatcher
     */
    protected $couponEventDispatcher;

    /**
     * @var OrderCouponFactory
     *
     * orderCouponFactory
     */
    protected $orderCouponFactory;

    /**
     * construct method
     *
     * @param ObjectManager         $orderCouponObjectManager OrderCoupon ObjectManager
     * @param CouponEventDispatcher $couponEventDispatcher    CouponEventDispatcher
     * @param OrderCouponFactory    $orderCouponFactory       OrderCoupon factory
     */
    public function __construct(
        ObjectManager $orderCouponObjectManager,
        CouponEventDispatcher $couponEventDispatcher,
        OrderCouponFactory $orderCouponFactory
    )
    {
        $this->orderCouponObjectManager = $orderCouponObjectManager;
        $this->couponEventDispatcher = $couponEventDispatcher;
        $this->orderCouponFactory = $orderCouponFactory;
    }

    /**
     * Event subscribed on OrderCoupon applied into an order.
     *
     * Just should create a new OrderCoupon instance, persist and flush it
     *
     * Also notifies to CouponBundle that a simple coupon has been
     * used by an Order.
     *
     * @param OrderCouponOnApplyEvent $event Event
     */
    public function onOrderCouponApply(OrderCouponOnApplyEvent $event)
    {
        $order = $event->getOrder();
        $coupon = $event->getCoupon();

        $orderCoupon = $this->orderCouponFactory->create();
        $orderCoupon
            ->setOrder($order)
            ->setCoupon($coupon);

        $this->orderCouponObjectManager->persist($orderCoupon);
        $this->orderCouponObjectManager->flush($orderCoupon);

        $this
            ->couponEventDispatcher
            ->notifyCouponUsage($coupon);
    }
}
