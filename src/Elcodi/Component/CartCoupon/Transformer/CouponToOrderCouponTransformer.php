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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;
use Elcodi\Component\CartCoupon\Factory\OrderCouponFactory;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\EventDispatcher\CouponEventDispatcher;

/**
 * Class CouponToOrderCouponTransformer.
 *
 * API methods:
 *
 * * createOrderCouponByCoupon(OrderInterface, CouponInterface)
 *
 * @api
 */
class CouponToOrderCouponTransformer
{
    /**
     * @var ObjectManager
     *
     * cartCouponObjectManager
     */
    private $orderCouponObjectManager;

    /**
     * @var CouponEventDispatcher
     *
     * CouponEventDispatcher
     */
    private $couponEventDispatcher;

    /**
     * @var OrderCouponFactory
     *
     * orderCouponFactory
     */
    private $orderCouponFactory;

    /**
     * construct method.
     *
     * @param ObjectManager         $orderCouponObjectManager OrderCoupon ObjectManager
     * @param CouponEventDispatcher $couponEventDispatcher    CouponEventDispatcher
     * @param OrderCouponFactory    $orderCouponFactory       OrderCoupon factory
     */
    public function __construct(
        ObjectManager $orderCouponObjectManager,
        CouponEventDispatcher $couponEventDispatcher,
        OrderCouponFactory $orderCouponFactory
    ) {
        $this->orderCouponObjectManager = $orderCouponObjectManager;
        $this->couponEventDispatcher = $couponEventDispatcher;
        $this->orderCouponFactory = $orderCouponFactory;
    }

    /**
     * Creates a new OrderCoupon instance given a Coupon and saves it into the
     * persistence layer.
     *
     * Also notifies to CouponBundle that a simple coupon has been
     * used by an Order.
     *
     * @param OrderInterface  $order  Order
     * @param CouponInterface $coupon Coupon
     *
     * @return OrderCouponInterface Order coupon created
     */
    public function createOrderCouponByCoupon(
        OrderInterface $order,
        CouponInterface $coupon
    ) {
        $orderCoupon = $this
            ->orderCouponFactory
            ->create()
            ->setOrder($order)
            ->setCoupon($coupon)
            ->setAmount($coupon->getAbsolutePrice())
            ->setName($coupon->getName())
            ->setCode($coupon->getCode());

        $this
            ->orderCouponObjectManager
            ->persist($orderCoupon);

        $this
            ->orderCouponObjectManager
            ->flush($orderCoupon);

        $this
            ->couponEventDispatcher
            ->notifyCouponUsage($coupon);

        return $orderCoupon;
    }
}
