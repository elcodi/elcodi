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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Interface PriceInterface.
 */
interface PriceInterface
{
    /**
     * Gets the purchasable or purchasables amount with tax.
     *
     * @return MoneyInterface Purchasable amount with tax
     */
    public function getPurchasableAmount();

    /**
     * Sets the purchasable or purchasables amount with tax.
     *
     * @param MoneyInterface $purchasableAmount purchasable amount with tax
     *
     * @return $this Self object
     */
    public function setPurchasableAmount(MoneyInterface $purchasableAmount);

    /**
     * Gets the total amount with tax.
     *
     * @return MoneyInterface price with tax
     */
    public function getAmount();

    /**
     * Sets the total amount with tax.
     *
     * @param MoneyInterface $amount amount without tax
     *
     * @return $this Self object
     */
    public function setAmount(MoneyInterface $amount);
}
