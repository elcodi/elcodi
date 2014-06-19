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
use Elcodi\CartBundle\Event\CartPreLoadEvent;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CartCouponBundle\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\CartCouponBundle\Services\CartCouponManager;
use Elcodi\CartCouponBundle\Services\CartCouponRuleManager;
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
     * @var CartCouponRuleManager
     *
     * CartCoupon Rule managers
     */
    protected $cartCouponRuleManager;

    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event Dispatcher
     */
    protected $cartCouponEventDispatcher;

    /**
     * Construct method
     *
     * @param CouponManager             $couponManager             Coupon manager
     * @param CartCouponManager         $cartCouponManager         Cart coupon manager
     * @param CurrencyWrapper           $currencyWrapper           Currency wrapper
     * @param CurrencyConverter         $currencyConverter         Currency converter
     * @param CartCouponRuleManager     $cartCouponRuleManager     CartCouponRuleManager
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher $cartCouponEventDispatcher
     */
    public function __construct(
        CouponManager $couponManager,
        CartCouponManager $cartCouponManager,
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter,
        CartCouponRuleManager $cartCouponRuleManager,
        CartCouponEventDispatcher $cartCouponEventDispatcher
    )
    {
        $this->couponManager = $couponManager;
        $this->cartCouponManager = $cartCouponManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
        $this->cartCouponRuleManager = $cartCouponRuleManager;
        $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
    }

    /**
     * Method subscribed to PreCartLoad event
     *
     * Checks if all Coupons applied to current cart are still valid.
     * If are not, they will be deleted from the Cart and new Event typeof
     * CartCouponOnRejected will be dispatched
     *
     * @param CartPreLoadEvent $cartPreLoadEvent Event
     */
    public function onCartPreLoadCoupons(CartPreLoadEvent $cartPreLoadEvent)
    {
        $cart = $cartPreLoadEvent->getCart();
        $cartCoupons = $this
            ->cartCouponManager
            ->getCartCoupons($cart);

        /**
         * @var CartCouponInterface $cartCoupon
         */
        foreach ($cartCoupons as $cartCoupon) {

            $coupon = $cartCoupon->getCoupon();
            if (!$this
                ->cartCouponRuleManager
                ->checkCouponValidity(
                    $cart,
                    $coupon
                )
            ) {
                $this->cartCouponManager->removeCoupon($cart, $coupon);

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
     * @param CartOnLoadEvent $cartOnLoadEvent Event
     */
    public function onCartLoadCoupons(CartOnLoadEvent $cartOnLoadEvent)
    {
        $cart = $cartOnLoadEvent->getCart();
        $couponAmount = Money::create(
            0,
            $this->currencyWrapper->loadCurrency()
        );
        $coupons = $this
            ->cartCouponManager
            ->getCoupons($cart);

        /**
         * @var CouponInterface $coupon
         */
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
