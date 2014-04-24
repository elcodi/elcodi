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

namespace Elcodi\CartBundle\Entity\Interfaces;

/**
 * Class PriceInterface
 */
interface PriceInterface
{
    /**
    * Get product amount with tax
    *
    * @return float Product amount with tax
    */
    public function getProductAmount();

    /**
    * Set product amount with tax
    *
    * @param float $productAmount Product amount with tax
    *
    * @return Object self Object
    */
    public function setProductAmount($productAmount);

    /**
    * Get coupon amount with tax
    *
    * @return float Coupon amount with tax
    */
    public function getCouponAmount();

    /**
    * Set coupon amount with tax
    *
    * @param float $couponAmount Coupon amount with tax
    *
    * @return Object self Object
    */
    public function setCouponAmount($couponAmount);

    /**
    * Get amount with tax
    *
    * @return float price with tax
    */
    public function getAmount();

    /**
    * Set amount with tax
    *
    * @param float $amount price with tax
    *
    * @return Object self Object
    */
    public function setAmount($amount);
}
