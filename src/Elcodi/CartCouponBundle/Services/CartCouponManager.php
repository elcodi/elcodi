<?php

/**
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
 */

namespace Elcodi\CartCouponBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CartCouponBundle\EventDispatcher\CartCouponEventDispatcher;

use Elcodi\CartCouponBundle\Repository\CartCouponRepository;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Exception\CouponAppliedException;
use Elcodi\CouponBundle\Exception\CouponFreeShippingExistsException;
use Elcodi\CouponBundle\Exception\CouponNotAvailableException;
use Elcodi\CouponBundle\Repository\CouponRepository;
use Elcodi\CouponBundle\Services\CouponManager;

/**
 * CartCoupon Manager
 *
 * This class aims to be a bridge between Coupons and Carts.
 * Manages all coupons instances inside Carts
 *
 * Public methods:
 *
 * getCartCoupons(CartInterface) : Collection
 * addCouponByCode(CartInterface, $couponCode) : self
 * removeCouponByCode(CartInterface, $couponCode) : self
 * addCoupon(CartInterface, CouponInterface) : self
 * removeCoupon(CartInterface, CouponInterface) : self
 */
class CartCouponManager
{
    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event dispatcher
     */
    protected $cartCouponEventDispatcher;

    /**
     * @var CouponManager
     *
     * CouponManager
     */
    protected $couponManager;

    /**
     * @var CouponRepository
     *
     * Coupon Repository
     */
    protected $couponRepository;

    /**
     * @var CartCouponRepository
     *
     * Coupon Repository
     */
    protected $cartCouponRepository;

    /**
     * construct method
     *
     */
    public function __construct(
        CartCouponEventDispatcher $cartCouponEventDispatcher,
        CouponManager $couponManager,
        CouponRepository $couponRepository,
        CartCouponRepository $cartCouponRepository
    )
    {
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
     * @return Collection OrderCoupons
     */
    public function getCartCoupons(CartInterface $cart)
    {
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
     * @throws CouponNotAvailableException
     * @throws CouponAppliedException
     * @throws CouponFreeShippingExistsException
     *
     * @return boolean Coupon has added to Cart
     */
    public function addCouponByCode(CartInterface $cart, $couponCode)
    {
        $coupon = $this
            ->couponRepository
            ->findOneBy(array(
                'code'    => $couponCode,
                'enabled' => true,
            ));

        if (!($coupon instanceof CouponInterface)) {
            return false;
        }

        return $this->addCoupon($cart, $coupon);
    }

    /**
     * Adds a Coupon to a Cart and recalculates the Cart Totals
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to add
     *
     * @throws CouponAppliedException
     * @throws CouponFreeShippingExistsException
     *
     * @return boolean Coupon has added to Cart
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
            ->findOneBy(array(
                'code' => $couponCode,
            ));

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
            ->findBy(array(
                'cart'   => $cart,
                'coupon' => $coupon,
            ));

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
