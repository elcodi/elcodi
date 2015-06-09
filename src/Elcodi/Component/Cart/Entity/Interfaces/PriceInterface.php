<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Interface PriceInterface
 */
interface PriceInterface
{
    /**
     * Gets the product or products amount without taxes
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getPreTaxProductAmount();

    /**
     * Gets the amount of taxes applied to the product
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getTaxProductAmount();

    /**
     * Gets the product or products amount with taxes
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getProductAmount();

    /**
     * Sets the product or products amount without taxes
     *
     * @param MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setPreTaxProductAmount(MoneyInterface $amount);

    /**
     * Sets the amount of taxes applied to the product
     *
     * @param MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setTaxProductAmount(MoneyInterface $amount);

    /**
     * Sets the product or products amount with taxes
     *
     * @param MoneyInterface $amount product amount with tax
     *
     * @return $this Self object
     */
    public function setProductAmount(MoneyInterface $amount);

    /**
     * Gets the total line amount without taxes
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getPreTaxAmount();

    /**
     * Gets the amount of taxes applied to this line
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getTaxAmount();

    /**
     * Gets the total line amount with taxes
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getAmount();

    /**
     * Sets the total line amount without taxes
     *
     * @param MoneyInterface $amount
     *
     * @return $this Self object
     */
    public function setPreTaxAmount(MoneyInterface $amount);

    /**
     * Sets the amount of taxes applied to this line
     *
     * @param MoneyInterface $amount
     *
     * @return $this Self object
     */
    public function setTaxAmount(MoneyInterface $amount);
    
    /**
     * Sets the total line amount with taxes
     *
     * @param MoneyInterface $amount amount without tax
     *
     * @return $this Self object
     */
    public function setAmount(MoneyInterface $amount);
}
