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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;

/**
 * Interface OrderLineInterface
 */
interface OrderLineInterface
    extends
    IdentifiableInterface,
    PurchasableWrapperInterface,
    PriceInterface,
    DimensionableInterface
{
    /**
     * Set Order
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Set the height
     *
     * @param integer $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height);

    /**
     * Set the width
     *
     * @param integer $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Set the depth
     *
     * @param integer $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth);

    /**
     * Set the weight
     *
     * @param integer $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight);

    /**
     * Set taxPercentage
     *
     * @param float $taxPercentage
     *
     * @return $this Self object
     */
    public function setTaxPercentage($taxPercentage);

    /**
     * Get taxPercentage
     *
     * @return float
     */
    public function getTaxPercentage();

    /**
     * Get Taxed Price
     *
     * @return MoneyInterface
     */
    public function getTaxedAmount();

    /**
     * Get Tax Amount
     *
     * @return MoneyInterface
     */
    public function getTaxAmount();
}
