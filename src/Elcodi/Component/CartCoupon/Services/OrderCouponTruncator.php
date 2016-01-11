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

namespace Elcodi\Component\CartCoupon\Services;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Repository\OrderCouponRepository;

/**
 * Class OrderCouponTruncator.
 *
 * API methods:
 *
 * * truncateOrderCoupons(OrderInterface)
 *
 * @api
 */
class OrderCouponTruncator
{
    /**
     * @var OrderCouponRepository
     *
     * OrderCoupon repository
     */
    private $orderCouponRepository;

    /**
     * @var ObjectManager
     *
     * Object manager
     */
    private $orderCouponObjectManager;

    /**
     * construct method.
     *
     * @param OrderCouponRepository $orderCouponRepository    OrderCoupon repository
     * @param ObjectManager         $orderCouponObjectManager OrderCoupon object manager
     */
    public function __construct(
        OrderCouponRepository $orderCouponRepository,
        ObjectManager $orderCouponObjectManager
    ) {
        $this->orderCouponRepository = $orderCouponRepository;
        $this->orderCouponObjectManager = $orderCouponObjectManager;
    }

    /**
     * Purge existing OrderCoupons.
     *
     * @param OrderInterface $order Order where to delete all coupons
     *
     * @return $this Self object
     */
    public function truncateOrderCoupons(OrderInterface $order)
    {
        $orderCoupons = $this
            ->orderCouponRepository
            ->findOrderCouponsByOrder($order);

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
