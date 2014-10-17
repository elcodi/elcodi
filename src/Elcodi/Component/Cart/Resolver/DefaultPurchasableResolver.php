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

namespace Elcodi\Component\Cart\Resolver;

use Elcodi\Component\Cart\Entity\Abstracts\AbstractLine;
use Elcodi\Component\Cart\Resolver\Interfaces\PurchasableResolverInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\Entity\Product;

/**
 * Class DefaultPurchasableResolver
 *
 * Resolves a Purchasable and implements concrete actions
 * to be carried out when getting or setting it on an
 * AbstractLine.
 *
 * This implementation knows only two types of Purchasable:
 * Product and Variant
 *
 * A Purchasable represent the item being purchased, be it
 * a ProductInterface or VariantInterface.
 *
 * When setting a Purchasable on a AbstractLine, different
 * actions occur depending on the actual type of the Purchasable:
 *
 * If it is a Product, AbstractLine::product is set to $purchasable
 * and CartLine::variant is set to NULL
 *
 * If it is a Variant, AbstractLine::variant is set to $purchasable
 * and CartLine::product is set to $purchasable->getProduct()
 *
 * The same logic, albeit inverted, is used when getting the
 * Purchasable from AbstractLine
 *
 * @link http://docs.elcodi.io/en/latest/bundles/CartBundle/services.html#cartbundle-services-addpurchasable
 *
 * @see ProductInterface
 * @see VariantInterface
 */
class DefaultPurchasableResolver implements PurchasableResolverInterface
{
    /**
     * PurchasableResolver constructor
     *
     * @param AbstractLine $line
     */
    public function __construct(AbstractLine $line)
    {
        $this->line = $line;
    }

    /**
     * @var AbstractLine
     *
     * Concrete AbstractLine to be injected
     */
    protected $line;

    /**
     * Sets the purchasable in current line
     *
     * @param PurchasableInterface $purchasable Purchasable object
     *
     * @return $this self Object
     */
    public function setPurchasable(PurchasableInterface $purchasable)
    {
        /**
         * @var Product $product
         */
        if ($purchasable instanceof VariantInterface) {

            $this->line->setVariant($purchasable);
            $product = $purchasable->getProduct();

        } else {
            /**
             * In the default implementation, the only
             * possible concrete implementations of
             * PurchasableInterface are 'Variant' or 'Product'
             */
            $product = $purchasable;
        }

        $this->line->setProduct($product);

        return $this;
    }

    /**
     * Gets the purchasable from current line
     *
     * @return PurchasableInterface
     */
    public function getPurchasable()
    {
        if ($this->line->getVariant() instanceof VariantInterface) {
            return $this->line->getVariant();

        }

        /**
         * In the default implementation, the only
         * possible concrete implementations of
         * PurchasableInterface are 'Variant' or 'Product'
         */

        return $this->line->getProduct();
    }
}
