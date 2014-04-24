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

/**
 * trait for add Entity enabled funct
 */
trait PriceTrait
{
    /**
     * @var float
     */
    protected $productAmount = 0;

    /**
     * @var float
     */
    protected $couponAmount = 0;

    /**
     * @var float
     */
    protected $amount = 0;

    /**
    * Get product amount with tax
    *
    * @return float Product amount with tax
    */
    public function getProductAmount()
    {
        return $this->productAmount;
    }

    /**
    * Set product amount with tax
    *
    * @param float $productAmount product amount with tax
    *
    * @return Object self Object
    */
    public function setProductAmount($productAmount)
    {
        $this->productAmount = $productAmount;

        return $this;
    }

    /**
    * Get coupon amount with tax
    *
    * @return float Coupon amount with tax
    */
    public function getCouponAmount()
    {
        return $this->couponAmount;
    }

    /**
    * Set coupon amount with tax
    *
    * @param float $couponAmount Coupon amount without tax
    *
    * @return Object self Object
    */
    public function setCouponAmount($couponAmount)
    {
        $this->couponAmount = $couponAmount;

        return $this;
    }

    /**
    * Get amount with tax
    *
    * @return float price with tax
    */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
    * Set amount with tax
    *
    * @param float $amount amount without tax
    *
    * @return $this
    */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }
}
