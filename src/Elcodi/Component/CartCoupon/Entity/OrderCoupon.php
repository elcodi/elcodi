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

namespace Elcodi\Component\CartCoupon\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class OrderCoupon.
 */
class OrderCoupon implements OrderCouponInterface
{
    use IdentifiableTrait;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var CouponInterface
     *
     * Coupon
     */
    protected $coupon;

    /**
     * @var int
     *
     * Amount
     */
    protected $amount;

    /**
     * @var CurrencyInterface
     *
     * Amount currency
     */
    protected $amountCurrency;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * Sets Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get Order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets Coupon.
     *
     * @param CouponInterface $coupon Coupon
     *
     * @return $this Self object
     */
    public function setCoupon(CouponInterface $coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Get Coupon.
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set code.
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name coupon name.
     *
     * @param string $name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set amount.
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setAmount(MoneyInterface $amount)
    {
        $this->amount = $amount->getAmount();
        $this->amountCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get amount.
     *
     * @return MoneyInterface Price
     */
    public function getAmount()
    {
        return Money::create(
            $this->amount,
            $this->amountCurrency
        );
    }
}
