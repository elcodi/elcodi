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

namespace Elcodi\CartCouponBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartCouponBundle\Repository\OrderCouponRepository;

/**
 * OrderCoupon Manager
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
    protected $orderCouponRepository;

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
     * Get cart coupons.
     *
     * If current cart has not coupons applied, this method will return an empty
     * collection
     *
     * @param OrderInterface $order Order
     *
     * @return Collection Coupons
     */
    public function getOrderCoupons(OrderInterface $order)
    {
        $orderCoupons = $this
            ->orderCouponRepository
            ->findBy(array(
                'order' => $order,
            ));

        if (!($orderCoupons instanceof Collection)) {

            $orderCoupons = new ArrayCollection($orderCoupons);
        }

        return $orderCoupons;
    }
}
