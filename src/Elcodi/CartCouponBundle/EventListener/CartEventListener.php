<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\EventListener;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartCouponBundle\Services\CartCouponManager;
use Elcodi\CouponBundle\ElcodiCouponTypes;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Services\CouponManager;

/**
 * Class CartEventListener
 *
 * This event listener should update the cart given in the event, applying
 * all the coupon features.
 */
class CartEventListener
{
    /**
     * @var CouponManager
     *
     * Coupon Manager
     */
    protected $couponManager;

    /**
     * @var CartCouponManager
     *
     * CartCouponManager
     */
    protected $cartCouponManager;

    /**
     * Construct method
     *
     * @param CouponManager     $couponManager     Coupon manager
     * @param CartCouponManager $cartCouponManager Cart coupon manager
     */
    public function __construct(CouponManager $couponManager, CartCouponManager $cartCouponManager)
    {
        $this->couponManager = $couponManager;
        $this->cartCouponManager = $cartCouponManager;
    }

    /**
     * Method subscribed to CartLoad event
     *
     * @param CartOnLoadEvent $cartOnLoadEvent Event
     *
     * @return CartInterface Cart
     */
    public function onCartOnLoad(CartOnLoadEvent $cartOnLoadEvent)
    {
        $cart = $cartOnLoadEvent->getCart();
        $couponAmount = 0.0;
        $cartCoupons = $this->cartCouponManager->getCartCoupons($cart);

        foreach ($cartCoupons as $coupon) {

            $couponAmount += $this->getPriceCoupon($cart, $coupon);
        }

        $cart->setCouponAmount($couponAmount);
        $cart->setAmount($cart->getAmount() + $couponAmount);

        return $cart;
    }

    /**
     * Given a cart and a coupon, returns the real value of the coupon
     *
     * @param CartInterface   $cart   Abstract Cart object
     * @param CouponInterface $coupon Coupon
     *
     * @return float Coupon price
     */
    protected function getPriceCoupon(CartInterface $cart, CouponInterface $coupon)
    {
        $priceCoupon = 0.0;

        switch ($coupon->getType()) {

            case ElcodiCouponTypes::TYPE_AMOUNT:
                $priceCoupon = (float) $coupon->getValue();
                break;

            case ElcodiCouponTypes::TYPE_PERCENT:
                $priceCoupon = ($coupon->getValue() / 100) * $cart->getProductAmount();
                break;
        }

        return $priceCoupon;
    }
}
