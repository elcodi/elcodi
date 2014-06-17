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

namespace Elcodi\CartCouponBundle\EventListener;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CartCouponBundle\Services\CartCouponManager;
use Elcodi\CouponBundle\ElcodiCouponTypes;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Services\CouponManager;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Services\CurrencyConverter;
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;

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
     * @var CurrencyConverter
     *
     * Currency converter
     */
    protected $currencyConverter;

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * Construct method
     *
     * @param CouponManager     $couponManager     Coupon manager
     * @param CartCouponManager $cartCouponManager Cart coupon manager
     * @param CurrencyWrapper   $currencyWrapper   Currency wrapper
     * @param CurrencyConverter $currencyConverter Currency converter
     */
    public function __construct(
        CouponManager $couponManager,
        CartCouponManager $cartCouponManager,
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter
    )
    {
        $this->couponManager = $couponManager;
        $this->cartCouponManager = $cartCouponManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Method subscribed to CartLoad event
     *
     * @param CartOnLoadEvent $cartOnLoadEvent Event
     *
     * @return CartInterface Cart
     */
    public function onCartLoadCoupons(
        CartOnLoadEvent $cartOnLoadEvent
    )
    {
        $cart = $cartOnLoadEvent->getCart();
        $couponAmount = Money::create(
            0,
            $this->currencyWrapper->loadCurrency()
        );
        $cartCoupons = $this
            ->cartCouponManager
            ->getCartCoupons($cart);

        /**
         * @var CartCouponInterface $cartCoupon
         */
        foreach ($cartCoupons as $cartCoupon) {

            $coupon = $cartCoupon->getCoupon();
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

        return $cart;
    }

    /**
     * Given a cart and a coupon, returns the real value of the coupon
     *
     * @param CartInterface   $cart   Abstract Cart object
     * @param CouponInterface $coupon Coupon
     *
     * @return MoneyInterface Coupon price
     */
    protected function getPriceCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    )
    {
        $currency = $this->currencyWrapper->getCurrency();

        switch ($coupon->getType()) {

            case ElcodiCouponTypes::TYPE_AMOUNT:

                $amount = $coupon->getPrice();

                return $this
                    ->currencyConverter
                    ->convertMoney(
                        $amount,
                        $currency
                    );

            case ElcodiCouponTypes::TYPE_PERCENT:

                $couponPercent = $coupon->getDiscount();

                return $cart
                    ->getProductAmount()
                    ->multiply(($couponPercent / 100));
        }
    }
}
