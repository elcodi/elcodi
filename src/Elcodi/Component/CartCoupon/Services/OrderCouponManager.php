<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\CartCoupon\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;
use Elcodi\Component\CartCoupon\Repository\OrderCouponRepository;

/**
 * Class OrderCoupon Manager
 *
 * This class aims to be a bridge between Coupons and Orders.
 * Manages all coupons instances inside Orders
 *
 * Public methods:
 *
 * getOrderCoupons(OrderInterface)
 */
class OrderCouponManager
{
    /**
     * @var OrderCouponRepository
     *
     * orderCouponRepository
     */
    private $orderCouponRepository;

    /**
     * construct method
     *
     * @param OrderCouponRepository $orderCouponRepository OrderCoupon Repository
     */
    public function __construct(OrderCouponRepository $orderCouponRepository)
    {
        $this->orderCouponRepository = $orderCouponRepository;
    }

    /**
     * Get OrderCoupon instances assigned to current order
     *
     * @param OrderInterface $order Order
     *
     * @return Collection OrderCoupons
     */
    public function getOrderCoupons(OrderInterface $order)
    {
        return new ArrayCollection(
            $this
                ->orderCouponRepository
                ->createQueryBuilder('oc')
                ->where('oc.order = :order')
                ->setParameter('order', $order)
                ->getQuery()
                ->getResult()
        );
    }

    /**
     * Get order coupon Objects
     *
     * @param OrderInterface $order Order
     *
     * @return Collection Coupons
     */
    public function getCoupons(OrderInterface $order)
    {
        $orderCoupons = $this
            ->orderCouponRepository
            ->createQueryBuilder('oc')
            ->select(['o', 'oc'])
            ->innerJoin('oc.coupon', 'c')
            ->where('oc.order = :order')
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult();

        $coupons = array_map(function (OrderCouponInterface $orderCoupon) {
            return $orderCoupon->getCoupon();
        }, $orderCoupons);

        return new ArrayCollection($coupons);
    }
}
