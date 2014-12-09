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
 */

namespace Elcodi\Component\Cart\Entity\Abstracts;

use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Cart\Resolver\Interfaces\PurchasableResolverInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;

/**
 * Cart line
 */
abstract class AbstractLine
{
    use PriceTrait, DimensionsTrait;

    /**
     * @var integer
     *
     * Identifier
     */
    protected $id;

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
     * Get Id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the product
     *
     * @param ProductInterface $product Product
     *
     * @return $this self Object
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
     * Returns the product variant
     *
     * @return VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Sets the product variant
     *
     * @param VariantInterface $variant
     *
     * @return $this self Object
     */
    public function setVariant($variant)
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Sets quantity
     *
     * @param int $quantity Quantity
     *
     * @return $this self Object
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

    /**
     * Sets the Purchasable object on this line
     *
     * A resolver is needed so that the concrete logic for
     * handling different implementations of PurchasableInterface
     * can be plugged.
     *
     * Line entities in CartBundle use the DefaultPurchasableResolver
     *
     * @param PurchasableInterface $purchasable
     *
     * @return $this self Object
     */
    public function setPurchasable(PurchasableInterface $purchasable)
    {
        $this->getPurchasableResolver()->setPurchasable($purchasable);

        return $this;
    }

    /**
     * Gets the Purchasable object on this line
     *
     * @return PurchasableInterface
     */
    public function getPurchasable()
    {
        return $this->getPurchasableResolver()->getPurchasable();
    }

    /**
     * Returns a purchasable resolver
     *
     * A purchasable resolver is needed so that classes in the
     * hierarchy can plug-in specific logic when adding a
     * Purchasable to an AbstractLine
     *
     * @return PurchasableResolverInterface
     */
    abstract protected function getPurchasableResolver();
}
