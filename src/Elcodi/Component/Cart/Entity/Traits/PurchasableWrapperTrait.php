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

namespace Elcodi\Component\Cart\Entity\Traits;

use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Trait PurchasableWrapperTrait.
 */
trait PurchasableWrapperTrait
{
    /**
     * @var ProductInterface
     *
     * Product
     */
    protected $product;

    /**
     * @var VariantInterface
     *
     * Product variant
     */
    protected $variant;

    /**
     * @var PackInterface
     *
     * Pack
     */
    protected $pack;

    /**
     * @var int
     *
     * Quantity
     */
    protected $quantity;

    /**
     * Set the purchasable object. This method is responsible for choosing how
     * this object must be stored depending on the type.
     *
     * @param PurchasableInterface $purchasable Purchasable object
     *
     * @return $this Self object
     */
    public function setPurchasable(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ProductInterface) {
            $this->product = $purchasable;

            return $this;
        }

        if ($purchasable instanceof VariantInterface) {
            $this->variant = $purchasable;
            $product = $purchasable->getProduct();
            $this->product = $product;

            return $this;
        }

        if ($purchasable instanceof PackInterface) {
            $this->pack = $purchasable;
        }

        return $this;
    }

    /**
     * Gets the purchasable object.
     *
     * @return null|PurchasableInterface Purchasable instance
     */
    public function getPurchasable()
    {
        if ($this->variant instanceof VariantInterface) {
            return $this->variant;
        }

        if ($this->product instanceof ProductInterface) {
            return $this->product;
        }

        if ($this->pack instanceof PackInterface) {
            return $this->pack;
        }
    }

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
    public function setProduct(ProductInterface $product)
    {
        @trigger_error('Deprecated since version 1.0.13, to be removed in 2.0.0.
        Use setPurchasable instead', E_USER_DEPRECATED);

        $this->product = $product;

        return $this;
    }

    /**
     * Gets the product.
     *
     * @deprecated since version 1.0.13, to be removed in 2.0.0. Use
     *             getPurchasable instead.
     *
     * @return ProductInterface product attached to this cart line
     */
    public function getProduct()
    {
        @trigger_error('Deprecated since version 1.0.13, to be removed in 2.0.0.
        Use getPurchasable instead', E_USER_DEPRECATED);

        return $this->product;
    }

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
    public function setVariant(VariantInterface $variant)
    {
        @trigger_error('Deprecated since version 1.0.13, to be removed in 2.0.0.
        Use setPurchasable instead', E_USER_DEPRECATED);

        $this->variant = $variant;

        return $this;
    }

    /**
     * Returns the product variant.
     *
     * @deprecated since version 1.0.13, to be removed in 2.0.0. Use
     *             getPurchasable instead.
     *
     * @return VariantInterface Variant
     */
    public function getVariant()
    {
        @trigger_error('Deprecated since version 1.0.13, to be removed in 2.0.0.
        Use getPurchasable instead', E_USER_DEPRECATED);

        return $this->variant;
    }

    /**
     * Sets quantity.
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Gets quantity.
     *
     * @return int Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
