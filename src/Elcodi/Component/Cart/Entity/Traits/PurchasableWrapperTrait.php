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

namespace Elcodi\Component\Cart\Entity\Traits;

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Trait PurchasableWrapperTrait
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
     * @var integer
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
        if ($purchasable instanceof VariantInterface) {
            $this->setVariant($purchasable);
            $product = $purchasable->getProduct();
        } else {
            $product = $purchasable;
        }

        $this->setProduct($product);

        return $this;
    }

    /**
     * Gets the purchasable object
     *
     * @return PurchasableInterface
     */
    public function getPurchasable()
    {
        return ($this->getVariant() instanceof VariantInterface)
            ? $this->getVariant()
            : $this->getProduct();
    }

    /**
     * Sets the product
     *
     * @param ProductInterface $product Product
     *
     * @return $this Self object
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Gets the product
     *
     * @return ProductInterface product attached to this cart line
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets the product variant
     *
     * @param VariantInterface $variant Variant
     *
     * @return $this Self object
     */
    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Returns the product variant
     *
     * @return VariantInterface Variant
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Sets quantity
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
     * Gets quantity
     *
     * @return integer Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
