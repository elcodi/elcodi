<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Interface PurchasableWrapperInterface.
 */
interface PurchasableWrapperInterface
{
    /**
     * Set the purchasable object. This method is responsible for choosing how
     * this object must be stored depending on the type.
     *
     * @param PurchasableInterface $purchasable Purchasable object
     *
     * @return $this Self object
     */
    public function setPurchasable(PurchasableInterface $purchasable);

    /**
     * Gets the purchasable object.
     *
     * @return PurchasableInterface
     */
    public function getPurchasable();

    /**
     * Sets the product.
     *
     * @deprecated since version 1.0.13, to be removed in 2.0.0. Use
     *             setPurchasable instead.
     *
     * @param ProductInterface $product Product
     *
     * @return $this Self object
     */
    public function setProduct(ProductInterface $product);

    /**
     * Gets the product.
     *
     * @deprecated since version 1.0.13, to be removed in 2.0.0. Use
     *             getPurchasable instead.
     *
     * @return ProductInterface product attached to this cart line
     */
    public function getProduct();

    /**
     * Sets the product variant.
     *
     * @deprecated since version 1.0.13, to be removed in 2.0.0. Use
     *             setPurchasable instead.
     *
     * @param VariantInterface $variant Variant
     *
     * @return $this Self object
     */
    public function setVariant(VariantInterface $variant);

    /**
     * Returns the product variant.
     *
     * @deprecated since version 1.0.13, to be removed in 2.0.0. Use
     *             getPurchasable instead.
     *
     * @return VariantInterface Variant
     */
    public function getVariant();

    /**
     * Sets quantity.
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity);

    /**
     * Gets quantity.
     *
     * @return int Quantity
     */
    public function getQuantity();
}
