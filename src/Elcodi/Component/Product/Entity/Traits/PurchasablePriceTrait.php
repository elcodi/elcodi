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

namespace Elcodi\Component\Product\Entity\Traits;

/**
 * Trait PurchasablePriceTrait.
 *
 * Trait that defines common price members for a Purchasable
 */
trait PurchasablePriceTrait
{
    /**
     * @var int
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
     * @var int
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
     * Set price.
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->price = $amount->getAmount();
        $this->priceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price.
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
     * Set price.
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount Reduced Price
     *
     * @return $this Self object
     */
    public function setReducedPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->reducedPrice = $amount->getAmount();
        $this->reducedPriceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price.
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

    /**
     * Get price.
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Reduced Price
     */
    public function getResolvedPrice()
    {
        return $this->inOffer()
            ? $this->getReducedPrice()
            : $this->getPrice();
    }

    /**
     * Is in offer.
     *
     * @return bool Purchasable is in offer
     */
    public function inOffer()
    {
        return $this->reducedPrice > 0;
    }
}
