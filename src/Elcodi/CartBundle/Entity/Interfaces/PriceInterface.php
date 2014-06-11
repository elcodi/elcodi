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
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;

/**
 * Class PriceInterface
 */
interface PriceInterface
{
    /**
    * Gets total amount with tax
    *
    * @return MoneyInterface price with tax
    */
    public function getAmount();

    /**
    * Sets total amount with tax
    *
    * @param MoneyInterface $amount price with tax
    *
    * @return Object self Object
    */
    public function setAmount(MoneyInterface $amount);

    /**
     * Gets product amount with tax
     *
     * @return MoneyInterface price with tax
     */
    public function getProductAmount();

    /**
     * Sets product amount with tax
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return Object self Object
     */
    public function setProductAmount(MoneyInterface $amount);

    /**
     * Gets the associated currency
     *
<<<<<<< HEAD
     * @return \Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface
=======
     * @return CurrencyInterface
>>>>>>> Added missing Money support in Coupon and CartCoupon
     */
    public function getCurrency();

    /**
     * Sets the currency
     *
<<<<<<< HEAD
     * @param \Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface $currency
=======
     * @param CurrencyInterface $currency
>>>>>>> Added missing Money support in Coupon and CartCoupon
     *
     * @return Object self Object
     */
    public function setCurrency($currency);
}
