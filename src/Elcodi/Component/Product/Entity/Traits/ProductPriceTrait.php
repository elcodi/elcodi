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

namespace Elcodi\Component\Product\Entity\Traits;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;

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
     * @var CurrencyInterface
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
     * @var CurrencyInterface
     *
     * Reduced price currency
     */
    protected $reducedPriceCurrency;

    /**
     * Set price
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setPrice(MoneyInterface $amount)
    {
        $this->price = $amount->getAmount();
        $this->priceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price
     *
     * @return MoneyInterface Price
     */
    public function getPrice()
    {
        return Money::create(
            $this->price,
            $this->priceCurrency
        );
    }

    /**
     * Set price
     *
     * @param MoneyInterface $amount Reduced Price
     *
     * @return $this Self object
     */
    public function setReducedPrice(MoneyInterface $amount)
    {
        $this->reducedPrice = $amount->getAmount();
        $this->reducedPriceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price
     *
     * @return MoneyInterface Reduced Price
     */
    public function getReducedPrice()
    {
        return Money::create(
            $this->reducedPrice,
            $this->reducedPriceCurrency
        );
    }
}
