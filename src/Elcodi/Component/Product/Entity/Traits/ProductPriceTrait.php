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
 */

namespace Elcodi\Component\Product\Entity\Traits;

/**
 * Class ProductPriceTrait
 *
 * Trait that defines common price members for a Product
 */
trait ProductPriceTrait
{
    /**
     * @var float
     *
     * Product price
     */
    protected $price;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Product price currency
     */
    protected $priceCurrency;

    /**
     * @var float
     *
     * Reduced price
     */
    protected $reducedPrice;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Reduced price currency
     */
    protected $reducedPriceCurrency;

    /**
     * Set price
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount Price
     *
     * @return $this self Object
     */
    public function setPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->price = $amount->getAmount();
        $this->priceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Price
     */
    public function getPrice()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->price,
            $this->priceCurrency
        );
    }

    /**
     * Set price
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount Reduced Price
     *
     * @return $this self Object
     */
    public function setReducedPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->reducedPrice = $amount->getAmount();
        $this->reducedPriceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Reduced Price
     */
    public function getReducedPrice()
    {
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->reducedPrice,
            $this->reducedPriceCurrency
        );
    }

}
