<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Entity\Abstracts;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\CartBundle\Entity\Traits\PriceTrait;

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
     * @var integer
     *
     * Quantity
     */
    protected $quantity;

    /**
     * Set the product
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
     * Get the product
     *
     * @return ProductInterface product atached to this cart line
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set quantity
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
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
