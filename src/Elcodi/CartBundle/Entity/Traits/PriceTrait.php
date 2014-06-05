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

namespace Elcodi\CartBundle\Entity\Traits;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;

/**
 * Trait for entities that hold prices.
 *
 * Cart/Order related entities usually will have this trait.
 *
 * A more generic approach is needed in order to generalize the
 * amounts stored, whether they refer to products, discounts,
 * shipping, etc
 *
 * A currency is needed so that a {@see Money} value object can be
 * exploited when doing currency arithmetics. When Currency is not
 * set, it is not possible to return a Money object, so getters
 * wil return null
 */
trait PriceTrait
{
    /**
     * Amount for product or products
     *
     * @var integer
     */
    protected $productAmount = 0;

    /**
     * Amount for coupon or coupons
     *
     * @var integer
     */
    protected $couponAmount = 0;

    /**
     * Total amount
     *
     * @var integer
     */
    protected $amount = 0;

    /**
     * Currency for the amounts stored in this entity
     *
     * @var \Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface
     */
    protected $currency;

    /**
     * Gets the product or products amount with tax
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getProductAmount()
    {
        if ($this->currency instanceof CurrencyInterface) {
            return new Money($this->productAmount, $this->currency);
        }

        return null;
    }

    /**
     * Sets the product or products amount with tax
     *
     * @param MoneyInterface $productAmount product amount with tax
     *
     * @return Object self Object
     */
    public function setProductAmount(MoneyInterface $productAmount)
    {
        $this->productAmount = $productAmount->getAmount();
        $this->currency = $productAmount->getCurrency();

        return $this;
    }

    /**
     * Gets the coupon or coupons amount with tax
     *
     * @return MoneyInterface Coupon amount with tax
     */
    public function getCouponAmount()
    {
        if ($this->currency instanceof CurrencyInterface) {
            return new Money($this->couponAmount, $this->currency);
        }

        return null;
    }

    /**
     * Sets the coupon or coupons amount with tax
     *
     * @param MoneyInterface $couponAmount Coupon amount without tax
     *
     * @return Object self Object
     */
    public function setCouponAmount(MoneyInterface $couponAmount)
    {
        $this->productAmount = $couponAmount->getAmount();
        $this->currency = $couponAmount->getCurrency();

        return $this;
    }

    /**
     * Gets the total amount with tax
     *
     * @return MoneyInterface price with tax
     */
    public function getAmount()
    {
        if ($this->currency instanceof CurrencyInterface) {
            return new Money($this->amount, $this->currency);
        }

        return null;
    }

    /**
     * Sets the total amount with tax
     *
     * @param MoneyInterface $amount amount without tax
     *
     * @return $this
     */
    public function setAmount(MoneyInterface $amount)
    {
        $this->amount = $amount->getAmount();
        $this->currency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the associated currency
     *
     * @return \Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the currency
     *
     * @param \Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
}
