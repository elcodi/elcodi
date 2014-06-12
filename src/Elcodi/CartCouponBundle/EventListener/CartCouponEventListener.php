<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartCouponBundle\Event\CartCouponOnApplyEvent;
use Elcodi\CartCouponBundle\Event\CartCouponOnRemoveEvent;
use Elcodi\CartCouponBundle\Factory\CartCouponFactory;

/**
 * Class CartCouponEventListener
 */
class CartCouponEventListener
{
    /**
     * @var ObjectManager
     *
     * cartCouponObjectManager
     */
    protected $cartCouponObjectManager;

    /**
     * @var CartCouponFactory
     *
     * cartCouponFactory
     */
    protected $cartCouponFactory;

    /**
     * Construct method
     *
     * @param ObjectManager     $cartCouponObjectManager CartCoupon ObjectManager
     * @param CartCouponFactory $cartCouponFactory       CartCoupon Factory
     */
    public function __construct(
        ObjectManager $cartCouponObjectManager,
        CartCouponFactory $cartCouponFactory
    )
    {
        $this->cartCouponObjectManager = $cartCouponObjectManager;
        $this->cartCouponFactory = $cartCouponFactory;
    }

    /**
     * Applies Coupon in Cart, and flushes it
     *
     * @param CartCouponOnApplyEvent $event Event
     */
    public function onCartCouponApply(CartCouponOnApplyEvent $event)
    {
        $cart = $event->getCart();
        $coupon = $event->getCoupon();

        /**
         * We create a new instance of CartCoupon.
         * We also persist and flush relation
         */
        $cartCoupon = $this->cartCouponFactory->create();
        $cartCoupon
            ->setCart($cart)
            ->setCoupon($coupon);

        $this->cartCouponObjectManager->persist($cartCoupon);
        $this->cartCouponObjectManager->flush();

        $event->setCartCoupon($cartCoupon);
    }

    /**
     * Removes Coupon from Cart, and flushes it
     *
     * @param CartCouponOnRemoveEvent $event Event
     */
    public function onCartCouponRemove(CartCouponOnRemoveEvent $event)
    {
        $cartCoupon = $event->getCartCoupon();

        $this->cartCouponObjectManager->remove($cartCoupon);
        $this->cartCouponObjectManager->flush();
    }
}
