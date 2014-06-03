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
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;

/**
 * Class PriceInterface
 */
interface PriceInterface
{
    /**
    * Get product amount with tax
    *
    * @return MoneyInterface Product amount with tax
    */
    public function getProductAmount();

    /**
    * Set product amount with tax
    *
    * @param MoneyInterface $productAmount Product amount with tax
    *
    * @return Object self Object
    */
    public function setProductAmount(MoneyInterface $productAmount);

    /**
    * Get coupon amount with tax
    *
    * @return MoneyInterface Coupon amount with tax
    */
    public function getCouponAmount();

    /**
    * Set coupon amount with tax
    *
    * @param MoneyInterface $couponAmount Coupon amount with tax
    *
    * @return Object self Object
    */
    public function setCouponAmount(MoneyInterface $couponAmount);

    /**
    * Get amount with tax
    *
    * @return MoneyInterface price with tax
    */
    public function getAmount();

    /**
    * Set amount with tax
    *
    * @param MoneyInterface $amount price with tax
    *
    * @return Object self Object
    */
    public function setAmount(MoneyInterface $amount);
}
