<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Product\Entity\Interfaces;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Interface ProductPriceInterface
 *
 * Defines common price members for a Product
 */
interface ProductPriceInterface
{
    /**
     * Set price
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setPrice(MoneyInterface $amount);

    /**
     * Get price
     *
     * @return MoneyInterface Price
     */
    public function getPrice();

    /**
     * Set price
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount Reduced Price
     *
     * @return $this Self object
     */
    public function setReducedPrice(MoneyInterface $amount);

    /**
     * Get price
     *
     * @return MoneyInterface Reduced Price
     */
    public function getReducedPrice();
}
