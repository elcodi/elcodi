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

namespace Elcodi\Component\Shipping\Entity\Interfaces;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Interface CarrierPriceRangeInterface
 */
interface CarrierPriceRangeInterface extends CarrierRangeInterface
{
    /**
     * Sets from price
     *
     * @param MoneyInterface $price Price
     *
     * @return $this self object
     */
    public function setFromPrice(MoneyInterface $price);

    /**
     * Get from price
     *
     * @return MoneyInterface Price
     */
    public function getFromPrice();

    /**
     * Sets to price
     *
     * @param MoneyInterface $price Price
     *
     * @return $this self object
     */
    public function setToPrice(MoneyInterface $price);

    /**
     * Get to price
     *
     * @return MoneyInterface Price
     */
    public function getToPrice();
}
