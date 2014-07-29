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

namespace Elcodi\CartBundle\Entity\Abstracts;

use Elcodi\CartBundle\Entity\Traits\PriceTrait;
use Elcodi\CartBundle\Resolver\Interfaces\PurchasableResolverInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\PurchasableInterface;
use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;

/**
 * Cart line
 */
abstract class AbstractLine extends AbstractEntity
{
    use PriceTrait;

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
     * Sets the product
     *
     * @param ProductInterface $product Product
     *
     * @return AbstractLine self Object
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
     * @return AbstractLine self Object
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
     * @return AbstractLine self Object
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
     * @return AbstractLine self Object
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
