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

namespace Elcodi\Component\CartCoupon\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;

/**
 * Class OrderCouponRepository.
 */
class OrderCouponRepository extends EntityRepository
{
    /**
     * Find OrderCoupon instances assigned to current order.
     *
     * @param OrderInterface $order Order
     *
     * @return OrderCouponInterface[] OrderCoupons
     */
    public function findOrderCouponsByOrder(OrderInterface $order)
    {
        return $this
            ->createQueryBuilder('oc')
            ->where('oc.order = :order')
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find OrderCoupon instances assigned to current order.
     *
     * @param OrderInterface $order Order
     *
     * @return OrderCouponInterface[] OrderCoupons
     */
    public function findCouponsByOrder(OrderInterface $order)
    {
        $orderCoupons = $this
            ->createQueryBuilder('oc')
            ->where('oc.order = :order')
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult();

        return array_map(function (OrderCouponInterface $orderCoupon) {
            return $orderCoupon->getCoupon();
        }, $orderCoupons);
    }
}
