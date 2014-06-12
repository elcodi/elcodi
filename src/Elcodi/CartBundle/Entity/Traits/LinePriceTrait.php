<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */
 
namespace Elcodi\CartBundle\Entity\Traits;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;

/**
 * Class LinePriceTrait
 */
trait LinePriceTrait
{
    /**
     * Amount for product or products
     *
     * @var integer
     */
    protected $productAmount;

    /**
     * Currency for the amounts stored in this entity
     *
     * @var \Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface
     */
    protected $currency;

    /**
     * Gets the product or products amount with tax
     *
     * @return MoneyInterface Product amount with tax
     */
    public function getAmount()
    {
        if ($this->currency instanceof CurrencyInterface) {

            return Money::create($this->amount, $this->currency);
        }

        return null;
    }

    /**
     * Sets the product or products amount with tax
     *
     * @param MoneyInterface $productAmount product amount with tax
     *
     * @return Object self Object
     */
    public function setAmount(MoneyInterface $productAmount)
    {
        $this->amount = $productAmount->getAmount();
        $this->currency = $productAmount->getCurrency();

        return $this;
    }
}
 