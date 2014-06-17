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

namespace Elcodi\CartCouponBundle\EventDispatcher;

use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CoreBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CartCouponBundle\Event\CartCouponOnRemoveEvent;
use Elcodi\CartCouponBundle\Event\CartCouponOnApplyEvent;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartCouponBundle\ElcodiCartCouponEvents;

/**
 * Class CartCouponEventDispatcher
 */
class CartCouponEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch event just before a coupon is applied into a Cart
     *
     * @param CartInterface   $cart   Cart where to apply the coupon
     * @param CouponInterface $coupon Coupon to be applied
     *
     * @return CartCouponEventDispatcher self Object
     */
    public function dispatchCartCouponOnApplyEvent(
        CartInterface $cart,
        CouponInterface $coupon
    )
    {
        $event = new CartCouponOnApplyEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::CART_COUPON_ONAPPLY,
            $event
        );
    }

    /**
     * Dispatch event just before a coupon is removed into a Cart
     *
     * @param CartCouponInterface $cartCoupon CartCoupon to remove
     *
     * @return CartCouponEventDispatcher self Object
     */
    public function dispatchCartCouponOnRemoveEvent(
        CartCouponInterface $cartCoupon
    )
    {
        $cart = $cartCoupon->getCart();
        $coupon = $cartCoupon->getCoupon();

        $event = new CartCouponOnRemoveEvent($cart, $coupon);
        $event->setCartCoupon($cartCoupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::CART_COUPON_ONREMOVE,
            $event
        );
    }
}
