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

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\CartCoupon\Services\CartCouponManager;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Services\CouponManager;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class RefreshCouponsEventListener
 *
 * This event listener should update the cart given in the event, applying
 * all the coupon features.
 */
class RefreshCouponsEventListener
{
    /**
     * @var CouponManager
     *
     * Coupon Manager
     */
    private $couponManager;

    /**
     * @var CartCouponManager
     *
     * CartCouponManager
     */
    private $cartCouponManager;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event Dispatcher
     */
    private $cartCouponEventDispatcher;

    /**
     * Construct method
     *
     * @param CouponManager             $couponManager             Coupon manager
     * @param CartCouponManager         $cartCouponManager         Cart coupon manager
     * @param CurrencyWrapper           $currencyWrapper           Currency wrapper
     * @param CurrencyConverter         $currencyConverter         Currency converter
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher $cartCouponEventDispatcher
     */
    public function __construct(
        CouponManager $couponManager,
        CartCouponManager $cartCouponManager,
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter,
        CartCouponEventDispatcher $cartCouponEventDispatcher
    ) {
        $this->couponManager = $couponManager;
        $this->cartCouponManager = $cartCouponManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
        $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
    }

    /**
     * Method subscribed to CartLoad event
     *
     * Checks if all Coupons applied to current cart are still valid.
     * If are not, they will be deleted from the Cart and new Event typeof
     * CartCouponOnRejected will be dispatched
     *
     * @param CartOnLoadEvent $event Event
     */
    public function refreshCartCoupons(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

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
     * Method subscribed to CartLoad event.
     *
     * Calculates coupons price given actual Cart, and overrides Cart price
     * given new information.
     *
     * @param CartOnLoadEvent $event
     */
    public function refreshCouponAmount(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        $couponAmount = Money::create(
            0,
            $this
                ->currencyWrapper
                ->get()
        );

        $coupons = $this
            ->cartCouponManager
            ->getCoupons($cart);

        foreach ($coupons as $coupon) {
            $currentCouponAmount = $this
                ->getPriceCoupon(
                    $cart,
                    $coupon
                );
            $coupon->setAbsolutePrice($currentCouponAmount);
            $couponAmount = $couponAmount->add($currentCouponAmount);
        }

        $cart->setCouponAmount($couponAmount);
        $cart->setAmount($cart->getAmount()->subtract($couponAmount));
    }

    /**
     * Given a cart and a coupon, returns the real value of the coupon.
     * If the type of the coupon is not valid, then an empty Money instance will
     * be returned, with value 0.
     *
     * @param CartInterface   $cart   Abstract Cart object
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface Coupon price
     */
    private function getPriceCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        $currency = $this
            ->currencyWrapper
            ->get();

        $couponPrice = Money::create(
            0,
            $currency
        );

        switch ($coupon->getType()) {

            case ElcodiCouponTypes::TYPE_PERCENT:

                $couponPercent = $coupon->getDiscount();

                $couponPrice = $cart
                    ->getProductAmount()
                    ->multiply($couponPercent / 100);
                break;

            case ElcodiCouponTypes::TYPE_AMOUNT:

                $amount = $coupon->getPrice();

                $couponPrice = $this
                    ->currencyConverter
                    ->convertMoney(
                        $amount,
                        $currency
                    );
                break;
        }

        return $couponPrice;
    }
}
