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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface PurchasableInterface.
 *
 * a Purchasable is an object that:
 *
 * * Has a SKU (Stock Keeping Unit) code
 * * Has stock attribute, reporting the purchasable availability.
 * * Implements ProductPriceInterface, so that prices can be read and written
 *
 * Using this consistent interface, services and classes that operate on
 * these features (such as CartManager) will have a shallow dependency
 * with more concrete product classes or interfaces
 */
interface PurchasableInterface
    extends
    EnabledInterface,
    ProductPriceInterface,
    DimensionableInterface
{
    /**
     * Gets the variant SKU.
     *
     * @return string
     */
    public function getSku();

    /**
     * Sets the variant SKU.
     *
     * @param string $sku
     *
     * @return $this Self object
     */
    public function setSku($sku);

    /**
     * Gets the variant stock.
     *
     * @return int stock
     */
    public function getStock();

    /**
     * Sets the variant stock.
     *
     * @param int $stock
     *
     * @return $this Self object
     */
    public function setStock($stock);

    /**
     * Set the height.
     *
     * @param int $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height);

    /**
     * Set the width.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Set the depth.
     *
     * @param int $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth);

    /**
     * Set the weight.
     *
     * @param int $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight);
}
