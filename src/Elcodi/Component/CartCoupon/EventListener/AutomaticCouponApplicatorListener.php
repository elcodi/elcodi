<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\CartCoupon\EventListener;

use Doctrine\Common\Persistence\ObjectRepository;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;

/**
 * Class AutomaticCouponApplicatorListener
 */
class AutomaticCouponApplicatorListener
{
    /**
     * @var CartCouponManager
     *
     * Coupon manager
     */
    protected $cartCouponManager;

    /**
     * @var ObjectRepository
     *
     * Coupon Repository
     */
    protected $couponRepository;

    /**
     * Construct method
     *
     * @param CartCouponManager $cartCouponManager Manager for cart coupon rules
     * @param ObjectRepository  $couponRepository  Repository to get coupons
     */
    public function __construct(
        CartCouponManager $cartCouponManager,
        ObjectRepository $couponRepository
    ) {
        $this->cartCouponManager = $cartCouponManager;
        $this->couponRepository = $couponRepository;
    }

    /**
     * Method subscribed to PreCartLoad event
     *
     * Iterate over all automatic Coupons and check if they apply.
     * If any applies, it will be added to the Cart
     *
     * @param CartOnLoadEvent $event Event
     */
    public function tryAutomaticCoupons(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        if ($cart->getCartLines()->isEmpty()) {
            return;
        }

        /**
         * @var CouponInterface[] $automaticCoupons
         */
        $automaticCoupons = $this->couponRepository->findBy([
            'enforcement' => ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC,
        ]);

        foreach ($automaticCoupons as $coupon) {
            try {
                $this
                    ->cartCouponManager
                    ->addCoupon($cart, $coupon);

            } catch (AbstractCouponException $e) {
                // Silently tries next coupon on controlled exception
            }
        }
    }
}
