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

namespace Elcodi\CartBundle\Entity\Interfaces;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;

/**
 * Class PriceInterface
 */
interface PriceInterface
{
    /**
     * Gets the product or products amount with tax
     *
     * @return \Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface Product amount with tax
     */
    public function getProductAmount();

    /**
     * Sets the product or products amount with tax
     *
     * @param \Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface $productAmount product amount with tax
     *
     * @return Object self Object
     */
    public function setProductAmount(MoneyInterface $productAmount);

    /**
     * Gets the total amount with tax
     *
     * @return \Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface price with tax
     */
    public function getAmount();

    /**
     * Sets the total amount with tax
     *
     * @param \Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface $amount amount without tax
     *
     * @return Object self Object
     */
    public function setAmount(MoneyInterface $amount);
}
