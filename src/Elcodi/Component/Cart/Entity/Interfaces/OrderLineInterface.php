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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StatefulInterface;

/**
 * Class OrderLineInterface
 */
interface OrderLineInterface extends PriceInterface, DimensionableInterface, StatefulInterface
{
    /**
     * Set Order
     *
     * @param OrderInterface $order Order
     *
     * @return $this self Object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Set the product
     *
     * @param ProductInterface $product Product
     *
     * @return $this self Object
     */
    public function setProduct(ProductInterface $product);

    /**
     * Get the product
     *
     * @return ProductInterface product attached to this cart line
     */
    public function getProduct();

    /**
     * Returns the product variant
     *
     * @return VariantInterface
     */
    public function getVariant();

    /**
     * Sets the product variant
     *
     * @param VariantInterface $variant
     *
     * @return $this self Object
     */
    public function setVariant($variant);

    /**
     * Sets the Purchasable object on this line
     *
     * @param PurchasableInterface $purchasable
     *
     * @return OrderLineInterface
     */
    public function setPurchasable(PurchasableInterface $purchasable);

    /**
     * Gets the Purchasable object on this line
     *
     * @return PurchasableInterface
     */
    public function getPurchasable();

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return $this self Object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity();

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
