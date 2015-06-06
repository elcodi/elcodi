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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Cart\Entity\Traits\PurchasableWrapperTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\Tax\Entity\Traits\TaxTrait;

/**
 * OrderLine
 *
 * This entity is just an extension of existant order line with some additional
 * parameters
 */
class OrderLine implements OrderLineInterface
{
    use IdentifiableTrait,
        PurchasableWrapperTrait,
        PriceTrait,
        DimensionsTrait,
        TaxTrait;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var float
     *
     * Tax percentage applied to the product
     */
    protected $taxPercentage;

    /**
     * Set Order
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set taxPercentage
     *
     * @param float $taxPercentage
     *
     * @return $this Self object
     */
    public function setTaxPercentage($taxPercentage)
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    /**
     * Get taxPercentage
     *
     * @return float
     */
    public function getTaxPercentage()
    {
        return $this->taxPercentage;
    }

    /**
     * Get Taxed Amount
     *
     * @return MoneyInterface
     */
    public function getTaxedAmount()
    {
        return Money::create(
            $this->amount,
            $this->currency
        )->add( $this->getTaxAmount() );
    }

    /**
     * Get Tax Amount
     *
     * @return MoneyInterface
     */
    public function getTaxAmount()
    {
        if( isset( $this->taxPercentage ) )
        {
            return Money::create(
                $this->CalculateTaxAmount( $this->amount, $this->taxPercentage ),
                $this->currency
            );
        }else{
            return Money::create(
                0,
                $this->productCurrency
            );
        }
    }
}
