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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;

/**
 * Class CreateAndSaveCartCouponEventListener.
 */
final class CreateAndSaveCartCouponEventListener
{
    /**
     * @var CartCouponManager
     *
     * CartCoupon manager
     */
    private $cartCouponManager;

    /**
     * Construct method.
     *
     * @param CartCouponManager $cartCouponManager CartCoupon manager
     */
    public function __construct(CartCouponManager $cartCouponManager)
    {
        $this->cartCouponManager = $cartCouponManager;
    }

    /**
     * Creates a new CartCoupon instance.
     *
     * @param CartCouponOnApplyEvent $event Event
     */
    public function createAndSaveCartCoupon(CartCouponOnApplyEvent $event)
    {
        $cartCoupon = $this
            ->cartCouponManager
            ->createAndSaveCartCoupon(
                $event->getCart(),
                $event->getCoupon()
            );

        $event->setCartCoupon($cartCoupon);
    }
}
