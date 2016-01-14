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
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponIncompatibleException;
use Elcodi\Component\Coupon\Services\CouponManager;

/**
 * Class CartCouponValidator.
 *
 * API methods:
 *
 * * validateCartCoupons(CartInterface)
 * * validateCoupon(CouponInterface)
 *
 * @api
 */
class CartCouponValidator
{
    /**
     * @var CartCouponManager
     *
     * CartCouponManager
     */
    private $cartCouponManager;

    /**
     * @var CouponManager
     *
     * CouponManager
     */
    private $couponManager;

    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event Dispatcher
     */
    private $cartCouponEventDispatcher;

    /**
     * Construct method.
     *
     * @param CartCouponManager         $cartCouponManager         Cart coupon manager
     * @param CouponManager             $couponManager             Coupon Manager
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher $cartCouponEventDispatcher
     */
    public function __construct(
        CartCouponManager $cartCouponManager,
        CouponManager $couponManager,
        CartCouponEventDispatcher $cartCouponEventDispatcher
    ) {
        $this->cartCouponManager = $cartCouponManager;
        $this->couponManager = $couponManager;
        $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
    }

    /**
     * Checks if all Coupons applied to current cart are still valid.
     * If are not, they will be deleted from the Cart and new Event typeof
     * CartCouponOnRejected will be dispatched.
     *
     * @param CartInterface $cart Cart
     */
    public function validateCartCoupons(CartInterface $cart)
    {
        $cartCoupons = $this
            ->cartCouponManager
            ->getCartCoupons($cart);

        foreach ($cartCoupons as $cartCoupon) {
            $coupon = $cartCoupon->getCoupon();

            try {
                $this
                    ->cartCouponEventDispatcher
                    ->dispatchCartCouponOnCheckEvent(
                        $cart,
                        $coupon
                    );
            } catch (AbstractCouponException $exception) {
                $this
                    ->cartCouponManager
                    ->removeCoupon(
                        $cart,
                        $coupon
                    );

                $this
                    ->cartCouponEventDispatcher
                    ->dispatchCartCouponOnRejectedEvent(
                        $cart,
                        $coupon
                    );
            }
        }
    }

    /**
     * Check if cart meets basic requirements for a coupon.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @throws CouponIncompatibleException Coupon incompatible
     */
    public function validateCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        if ($cart->getTotalItemNumber() === 0) {
            throw new CouponIncompatibleException();
        }

        $this
            ->couponManager
            ->checkCoupon($coupon);
    }
}
