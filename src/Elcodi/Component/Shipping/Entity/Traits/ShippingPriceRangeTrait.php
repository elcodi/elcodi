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

namespace Elcodi\Component\Shipping\Entity\Traits;

/**
 * Trait ShippingPriceRangeTrait
 */
trait ShippingPriceRangeTrait
{
    /**
     * @var integer
     *
     * fromPriceAmount
     */
    protected $fromPriceAmount;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
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
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * toPriceCurrency
     */
    protected $toPriceCurrency;

    /**
     * Sets from price
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $price Price
     *
     * @return $this Self object
     */
    public function setFromPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $price)
    {
        $this->fromPriceAmount = $price->getAmount();
        $this->fromPriceCurrency = $price->getCurrency();

        return $this;
    }

    /**
     * Get from price
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Price
     */
    public function getFromPrice()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->fromPriceAmount,
            $this->fromPriceCurrency
        );
    }

    /**
     * Sets to price
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $price Price
     *
     * @return $this Self object
     */
    public function setToPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $price)
    {
        $this->toPriceAmount = $price->getAmount();
        $this->toPriceCurrency = $price->getCurrency();

        return $this;
    }

    /**
     * Get to price
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Price
     */
    public function getToPrice()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->toPriceAmount,
            $this->toPriceCurrency
        );
    }
}
