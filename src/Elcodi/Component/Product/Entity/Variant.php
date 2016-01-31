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

namespace Elcodi\Component\Product\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class Variant.
 *
 * A Product variant is a specific combination of finite options
 * for a given Product. The multiplicity of attribute/options define
 * a "tuple" of a product and its related options such that a specific
 * combination is univocally determined.
 *
 * A Variant will normally have a different SKU than its parent product,
 * so it can have independent stock and pricing informations.
 */
class Variant extends Purchasable implements VariantInterface
{
    /**
     * @var ProductInterface
     *
     * Parent product
     */
    protected $product;

    /**
     * @var Collection
     *
     * Collection of possible options for this product
     */
    protected $options;

    /**
     * Gets parent product.
     *
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets parent product.
     *
     * @param ProductInterface $product
     *
     * @return $this Self object
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Gets this variant option values.
     *
     * @return Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets this variant option values.
     *
     * @param Collection $options
     *
     * @return $this Self object
     */
    public function setOptions(Collection $options)
    {
        /**
         * We want to be able to assign an empty
         * ArrayCollection to variant options.
         *
         * When the collection is not empty, each
         * option in the collection will be added
         * separately since it needs to update the
         * parent product attribute list
         */
        if ($options->isEmpty()) {
            $this->options = $options;
        } else {
            $this->options->clear();
        }

        /**
         * @var ValueInterface $option
         */
        foreach ($options as $option) {

            /**
             * We need to update the parent product attribute collection.
             */
            $this->addOption($option);
        }

        return $this;
    }

    /**
     * Adds an option to this variant.
     *
     * Passed option Attribute is also added to the attribute collection
     * of the parent Product.
     *
     * If Variant::product is not set or does not implement ProductInterface
     * a LogicException is thrown: presence of the parent product is mandatory
     * since adding an Option to a Variant also updates the Parent product
     * Attribute collection. This way Variant::options and Product::attributes
     * are synchronized
     *
     * @param ValueInterface $option
     *
     * @throws \LogicException
     *
     * @return $this Self object
     */
    public function addOption(ValueInterface $option)
    {
        if (!$this->product instanceof ProductInterface) {
            throw new \LogicException('Cannot add options to a Variant before setting a parent Product');
        }

        $this
            ->options
            ->add($option);

        $this
            ->product
            ->addAttribute(
                $option->getAttribute()
            );

        return $this;
    }

    /**
     * Removes an option from this variant.
     *
     * @param ValueInterface $option
     *
     * @return $this Self object
     */
    public function removeOption(ValueInterface $option)
    {
        $this
            ->options
            ->removeElement($option);

        return $this;
    }

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories()
    {
        return $this
            ->getProduct()
            ->getCategories();
    }

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory()
    {
        return $this
            ->getProduct()
            ->getPrincipalCategory();
    }

    /**
     * Product manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer()
    {
        return $this
            ->getProduct()
            ->getManufacturer();
    }

    /**
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'product_variant';
    }
}
