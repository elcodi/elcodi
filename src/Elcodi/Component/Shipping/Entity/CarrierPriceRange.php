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

namespace Elcodi\Component\Shipping\Entity;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Shipping\Entity\Abstracts\AbstractCarrierRange;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierPriceRangeInterface;

/**
 * Class CarrierPriceRange
 */
class CarrierPriceRange extends AbstractCarrierRange implements CarrierPriceRangeInterface
{
    /**
     * @var integer
     *
     * fromPriceAmount
     */
    protected $fromPriceAmount;

    /**
     * @var CurrencyInterface
     *
     * fromPriceCurrency
     */
    protected $fromPriceCurrency;

    /**
     * @var integer
     *
     * toPriceAmount
     */
    protected $toPriceAmount;

    /**
     * @var CurrencyInterface
     *
     * toPriceCurrency
     */
    protected $toPriceCurrency;

    /**
     * Sets from price
     *
     * @param MoneyInterface $price Price
     *
     * @return $this self object
     */
    public function setFromPrice(MoneyInterface $price)
    {
        $this->fromPriceAmount = $price->getAmount();
        $this->fromPriceCurrency = $price->getCurrency();

        return $this;
    }

    /**
     * Get from price
     *
     * @return MoneyInterface Price
     */
    public function getFromPrice()
    {
        return Money::create(
            $this->fromPriceAmount,
            $this->fromPriceCurrency
        );
    }

    /**
     * Sets to price
     *
     * @param MoneyInterface $price Price
     *
     * @return $this self object
     */
    public function setToPrice(MoneyInterface $price)
    {
        $this->toPriceAmount = $price->getAmount();
        $this->toPriceCurrency = $price->getCurrency();

        return $this;
    }

    /**
     * Get to price
     *
     * @return MoneyInterface Price
     */
    public function getToPrice()
    {
        return Money::create(
            $this->toPriceAmount,
            $this->toPriceCurrency
        );
    }
}
