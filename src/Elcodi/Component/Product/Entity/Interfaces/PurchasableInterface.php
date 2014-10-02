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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface PurchasableInterface
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
 *
 */
interface PurchasableInterface
    extends
    EnabledInterface,
    ProductPriceInterface,
    DimensionableInterface
{
    /**
     * Gets the variant SKU
     *
     * @return string
     */
    public function getSku();

    /**
     * Sets the variant SKU
     *
     * @param string $sku
     *
     * @return $this self Object
     */
    public function setSku($sku);

    /**
     * Gets the variant stock
     *
     * @return int
     */
    public function getStock();

    /**
     * Sets the variant stock
     *
     * @param int $stock
     *
     * @return $this self Object
     */
    public function setStock($stock);

    /**
     * Set the height
     *
     * @param integer $height Height
     *
     * @return $this self Object
     */
    public function setHeight($height);

    /**
     * Set the width
     *
     * @param integer $width Width
     *
     * @return $this self Object
     */
    public function setWidth($width);

    /**
     * Set the depth
     *
     * @param integer $depth Depth
     *
     * @return $this self Object
     */
    public function setDepth($depth);

    /**
     * Set the weight
     *
     * @param integer $weight Weight
     *
     * @return $this self Object
     */
    public function setWeight($weight);
}
