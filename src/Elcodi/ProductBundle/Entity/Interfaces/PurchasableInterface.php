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

namespace Elcodi\ProductBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

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
interface PurchasableInterface extends EnabledInterface, ProductPriceInterface
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
     * @return VariantInterface
     */
    public function setStock($stock);
}
