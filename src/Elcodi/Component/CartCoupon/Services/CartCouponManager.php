<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponNotAvailableException;
use Elcodi\Component\Coupon\Repository\CouponRepository;
use Elcodi\Component\Coupon\Services\CouponManager;

/**
 * Class CartCoupon Manager
 *
 * This class aims to be a bridge between Coupons and Carts.
 * Manages all coupons instances inside Carts
 */
class CartCouponManager
{
    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event dispatcher
     */
    private $cartCouponEventDispatcher;

    /**
     * @var CouponManager
     *
     * CouponManager
     */
    private $couponManager;

    /**
     * @var CouponRepository
     *
     * Coupon Repository
     */
    private $couponRepository;

    /**
     * @var CartCouponRepository
     *
     * Coupon Repository
     */
    private $cartCouponRepository;

    /**
     * Construct method
     *
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher
     * @param CouponManager             $couponManager
     * @param CouponRepository          $couponRepository
     * @param CartCouponRepository      $cartCouponRepository
     */
    public function __construct(
        CartCouponEventDispatcher $cartCouponEventDispatcher,
        CouponManager $couponManager,
        CouponRepository $couponRepository,
        CartCouponRepository $cartCouponRepository
    ) {
        $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
        $this->couponManager = $couponManager;
        $this->couponRepository = $couponRepository;
        $this->cartCouponRepository = $cartCouponRepository;
    }

    /**
     * Get CartCoupon instances assigned to current Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartCouponInterface[]|Collection OrderCoupons
     */
    public function getCartCoupons(CartInterface $cart)
    {
        /**
         * If Cart id is null means that this cart has been generated from
         * scratch. This also means that it cannot have any Coupon associated.
         * If is this case, we avoid this lookup.
         */
        if ($cart->getId() === null) {
            return new ArrayCollection();
        }

        return new ArrayCollection(
            $this
                ->cartCouponRepository
                ->createQueryBuilder('cc')
                ->where('cc.cart = :cart')
                ->setParameter('cart', $cart)
                ->getQuery()
                ->getResult()
        );
    }

    /**
     * Get cart coupon objects
     *
     * @param CartInterface $cart Cart
     *
     * @return Collection Coupons
     */
    public function getCoupons(CartInterface $cart)
    {
        /**
         * If Cart id is null means that this cart has been generated from
         * scratch. This also means that it cannot have any Coupon associated.
         * If is this case, we avoid this lookup.
         */
        if ($cart->getId() === null) {
            return new ArrayCollection();
        }

        $cartCoupons = $this
            ->cartCouponRepository
            ->createQueryBuilder('cc')
            ->select(['c', 'cc'])
            ->innerJoin('cc.coupon', 'c')
            ->where('cc.cart = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getResult();

        $coupons = array_map(function (CartCouponInterface $cartCoupon) {
            return $cartCoupon->getCoupon();
        }, $cartCoupons);

        return new ArrayCollection($coupons);
    }

    /**
     * Given a coupon code, applies it to cart
     *
     * @param CartInterface $cart       Cart
     * @param string        $couponCode Coupon code
     *
     * @throws AbstractCouponException
     *
     * @return boolean Coupon has added to Cart
     */
    public function addCouponByCode(CartInterface $cart, $couponCode)
    {
        $coupon = $this
            ->couponRepository
            ->findOneBy([
                'code'    => $couponCode,
                'enabled' => true,
            ]);

        if (false === $coupon instanceof CouponInterface) {
            throw new CouponNotAvailableException();
        }

        return $this->addCoupon($cart, $coupon);
    }

    /**
     * Adds a Coupon to a Cart and recalculates the Cart Totals
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to add
     *
     * @throws AbstractCouponException
     *
     * @return $this Self object
     */
    public function addCoupon(CartInterface $cart, CouponInterface $coupon)
    {
        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnApplyEvent(
                $cart,
                $coupon
            );

        return $this;
    }

    /**
     * Given a coupon code, removes it from cart
     *
     * @param CartInterface $cart       Cart
     * @param string        $couponCode Coupon code
     *
     * @return boolean Coupon has been removed from cart
     */
    public function removeCouponByCode(CartInterface $cart, $couponCode)
    {
        $coupon = $this
            ->couponRepository
            ->findOneBy([
                'code' => $couponCode,
            ]);

        if (!($coupon instanceof CouponInterface)) {
            return false;
        }

        return $this->removeCoupon($cart, $coupon);
    }

    /**
     * Removes a Coupon from a Cart, and recalculates Cart Totals
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to remove
     *
     * @return boolean Coupon has been removed from cart
     */
    public function removeCoupon(CartInterface $cart, CouponInterface $coupon)
    {
        $cartCoupons = $this
            ->cartCouponRepository
            ->findBy([
                'cart'   => $cart,
                'coupon' => $coupon,
            ]);

        if (empty($cartCoupons)) {
            return false;
        }

        foreach ($cartCoupons as $cartCoupon) {
            $this
                ->cartCouponEventDispatcher
                ->dispatchCartCouponOnRemoveEvent(
                    $cartCoupon
                );
        }

        return true;
    }
}
