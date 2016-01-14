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

namespace Elcodi\Component\CartCoupon\EventDispatcher;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\ElcodiCartCouponEvents;
use Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface;
use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Event\CartCouponOnCheckEvent;
use Elcodi\Component\CartCoupon\Event\CartCouponOnRejectedEvent;
use Elcodi\Component\CartCoupon\Event\CartCouponOnRemoveEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class CartCouponEventDispatcher.
 */
class CartCouponEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch event to check a coupon applies to a Cart.
     *
     * @param CartInterface   $cart   Cart where the coupon should apply
     * @param CouponInterface $coupon Coupon to be checked
     *
     * @return $this Self object
     */
    public function dispatchCartCouponOnCheckEvent(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $event = new CartCouponOnCheckEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::CART_COUPON_ONCHECK,
            $event
        );
    }

    /**
     * Dispatch event just before a coupon is applied into a Cart.
     *
     * @param CartInterface   $cart   Cart where to apply the coupon
     * @param CouponInterface $coupon Coupon to be applied
     *
     * @return $this Self object
     */
    public function dispatchCartCouponOnApplyEvent(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $event = new CartCouponOnApplyEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::CART_COUPON_ONAPPLY,
            $event
        );
    }

    /**
     * Dispatch event just before a coupon is removed from a Cart.
     *
     * @param CartCouponInterface $cartCoupon CartCoupon to remove
     *
     * @return $this Self object
     */
    public function dispatchCartCouponOnRemoveEvent(
        CartCouponInterface $cartCoupon
    ) {
        $cart = $cartCoupon->getCart();
        $coupon = $cartCoupon->getCoupon();

        $event = new CartCouponOnRemoveEvent($cart, $coupon);
        $event->setCartCoupon($cartCoupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::CART_COUPON_ONREMOVE,
            $event
        );
    }

    /**
     * Dispatch event when a coupon application is rejected.
     *
     * @param CartInterface   $cart   Cart where the coupon should be rejected
     * @param CouponInterface $coupon Rejected coupon
     *
     * @return $this Self object
     */
    public function dispatchCartCouponOnRejectedEvent(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $event = new CartCouponOnRejectedEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::CART_COUPON_ONREJECTED,
            $event
        );
    }
}
