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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Repository\CartCouponRepository;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponNotAvailableException;
use Elcodi\Component\Coupon\Repository\CouponRepository;

/**
 * Class CartCoupon Manager.
 *
 * API methods:
 *
 * * createAndSaveCartCoupon(CartInterface, CouponInterface)
 * * getCartCoupons(CartInterface)
 * * getCoupons(CartInterface)
 * * addCouponByCode(CartInterface, $couponCode)
 * * addCoupon(CartInterface, CouponInterface)
 * * removeCouponByCode(CartInterface, $couponCode)
 * * removeCoupon(CartInterface, CouponInterface)
 * * removeCartCoupon(CartCouponInterface)
 *
 * @api
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
     * @var CouponRepository
     *
     * Coupon Repository
     */
    private $couponRepository;

    /**
     * @var ObjectDirector
     *
     * CartCoupon director
     */
    private $cartCouponDirector;

    /**
     * @var CartCouponRepository
     *
     * CartCoupon repository
     */
    private $cartCouponRepository;

    /**
     * Construct method.
     *
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher CartCoupon event dispatcher
     * @param CouponRepository          $couponRepository          Coupon Repository
     * @param ObjectDirector            $cartCouponDirector        CartCoupon director
     * @param CartCouponRepository      $cartCouponRepository      CartCoupon repository
     */
    public function __construct(
        CartCouponEventDispatcher $cartCouponEventDispatcher,
        CouponRepository $couponRepository,
        ObjectDirector $cartCouponDirector,
        CartCouponRepository $cartCouponRepository
    ) {
        $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
        $this->couponRepository = $couponRepository;
        $this->cartCouponDirector = $cartCouponDirector;
        $this->cartCouponRepository = $cartCouponRepository;
    }

    /**
     * Create a cart coupon given a cart and a coupon.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return CartCouponInterface Cart Coupon created
     */
    public function createAndSaveCartCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        /**
         * We create a new instance of CartCoupon.
         * We also persist and flush relation.
         */
        $cartCoupon = $this
            ->cartCouponDirector
            ->create();

        $cartCoupon->setCart($cart);
        $cartCoupon->setCoupon($coupon);

        $this
            ->cartCouponDirector
            ->save($cartCoupon);

        return $cartCoupon;
    }

    /**
     * Get CartCoupon instances assigned to current Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartCouponInterface[] CartCoupons
     */
    public function getCartCoupons(CartInterface $cart)
    {
        /**
         * If Cart id is null means that this cart has been generated from
         * scratch. This also means that it cannot have any Coupon associated.
         * If is this case, we avoid this lookup.
         */
        if ($cart->getId() === null) {
            return [];
        }

        return $this
            ->cartCouponRepository
            ->findCartCouponsByCart($cart);
    }

    /**
     * Get cart coupon objects.
     *
     * @param CartInterface $cart Cart
     *
     * @return CouponInterface[] Coupons
     */
    public function getCoupons(CartInterface $cart)
    {
        /**
         * If Cart id is null means that this cart has been generated from
         * scratch. This also means that it cannot have any Coupon associated.
         * If is this case, we avoid this lookup.
         */
        if ($cart->getId() === null) {
            return [];
        }

        return $this
            ->cartCouponRepository
            ->findCouponsByCart($cart);
    }

    /**
     * Given a coupon code, applies it to cart.
     *
     * @param CartInterface $cart       Cart
     * @param string        $couponCode Coupon code
     *
     * @throws AbstractCouponException
     *
     * @return bool Coupon has added to Cart
     */
    public function addCouponByCode(
        CartInterface $cart,
        $couponCode
    ) {
        $coupon = $this
            ->couponRepository
            ->findOneBy([
                'code' => $couponCode,
                'enabled' => true,
            ]);

        if (!($coupon instanceof CouponInterface)) {
            throw new CouponNotAvailableException();
        }

        return $this
            ->addCoupon(
                $cart,
                $coupon
            );
    }

    /**
     * Adds a Coupon to a Cart and recalculates the Cart Totals.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to add
     *
     * @throws AbstractCouponException
     *
     * @return $this Self object
     */
    public function addCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $this
            ->cartCouponEventDispatcher
            ->dispatchCartCouponOnApplyEvent(
                $cart,
                $coupon
            );

        return $this;
    }

    /**
     * Given a coupon code, removes it from cart.
     *
     * @param CartInterface $cart       Cart
     * @param string        $couponCode Coupon code
     *
     * @return bool Coupon has been removed from cart
     */
    public function removeCouponByCode(
        CartInterface $cart,
        $couponCode
    ) {
        $coupon = $this
            ->couponRepository
            ->findOneBy([
                'code' => $couponCode,
            ]);

        if (!($coupon instanceof CouponInterface)) {
            return false;
        }

        return $this
            ->removeCoupon(
                $cart,
                $coupon
            );
    }

    /**
     * Removes a Coupon from a Cart, and recalculates Cart Totals.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to remove
     *
     * @return bool Coupon has been removed from cart
     */
    public function removeCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $cartCoupons = $this
            ->cartCouponDirector
            ->findBy([
                'cart' => $cart,
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

    /**
     * Removed a CartCoupon.
     *
     * @param CartCouponInterface $cartCoupon Cart coupon
     */
    public function removeCartCoupon(CartCouponInterface $cartCoupon)
    {
        $this
            ->cartCouponDirector
            ->remove($cartCoupon);
    }
}
