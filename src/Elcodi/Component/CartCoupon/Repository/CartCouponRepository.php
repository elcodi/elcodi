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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class CartCouponRepository.
 */
class CartCouponRepository extends EntityRepository
{
    /**
     * Get CartCoupon instances assigned to current Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartCouponInterface[] Cart Coupons
     */
    public function findCartCouponsByCart(CartInterface $cart)
    {
        return $this
            ->createQueryBuilder('cc')
            ->where('cc.cart = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get cart coupon objects.
     *
     * @param CartInterface $cart Cart
     *
     * @return CouponInterface[] Coupons
     */
    public function findCouponsByCart(CartInterface $cart)
    {
        $cartCoupons = $this
            ->createQueryBuilder('cc')
            ->where('cc.cart = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getResult();

        return array_map(function (CartCouponInterface $cartCoupon) {
            return $cartCoupon->getCoupon();
        }, $cartCoupons);
    }
}
