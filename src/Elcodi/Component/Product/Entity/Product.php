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

namespace Elcodi\Component\Product\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ETaggableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\Product\Entity\Traits\ProductPriceTrait;

/**
 * Product entity
 */
class Product extends AbstractEntity implements ProductInterface
{
    use
        ProductPriceTrait,
        DateTimeTrait,
        EnabledTrait,
        ETaggableTrait,
        MetaDataTrait,
        ImagesContainerTrait,
        PrincipalImageTrait,
        DimensionsTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Product SKU
     */
    protected $sku;

    /**
     * @var integer
     *
     * Product type
     */
    protected $type;

    /**
     * @var int
     *
     * Stock
     */
    protected $stock;

    /**
     * @var string
     *
     * Slug
     */
    protected $slug;

    /**
     * @var string
     *
     * Short description
     */
    protected $shortDescription;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var boolean
     *
     * Product must show in home
     */
    protected $showInHome;

    /**
     * @var string
     *
     * Product dimensions
     */
    protected $dimensions;

    /**
     * @var Manufacturer
     *
     * Manufacturer
     */
    protected $manufacturer;

    /**
     * @var Collection
     *
     * Many-to-Many association between products and categories.
     */
    protected $categories;

    /**
     * @var CategoryInterface
     *
     * Principal category
     */
    protected $principalCategory;

    /**
     * @var Collection
     *
     * Attributes associated with this product
     */
    protected $attributes;

    /**
     * @var Collection
     *
     * Variants for this product
     */
    protected $variants;

    /**
     * @var VariantInterface
     *
     * Principal variant for this product
     */
    protected $principalVariant;

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return $this self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return $this self Object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return $this self Object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set short description
     *
     * @param string $shortDescription Short description
     *
     * @return $this self Object
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get short description
     *
     * @return string Short description
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set categories
     *
     * @param Collection $categories Categories
     *
     * @return $this self Object
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return Collection Categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add category
     *
     * @param CategoryInterface $category Category
     *
     * @return $this self Object
     */
    public function addCategory(CategoryInterface $category)
    {
        $this->categories->add($category);

        return $this;
    }

    /**
     * Remove category
     *
     * @param CategoryInterface $category Category
     *
     * @return $this self Object
     */
    public function removeCategory(CategoryInterface $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * Set the principalCategory
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return $this self Object
     */
    public function setPrincipalCategory(CategoryInterface $principalCategory = null)
    {
        $this->principalCategory = $principalCategory;

        return $this;
    }

    /**
     * Get the principalCategory
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory()
    {
        return $this->principalCategory;
    }

    /**
     * Set stock
     *
     * @param int $stock Stock
     *
     * @return $this self Object
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set show in home
     *
     * @param boolean $showInHome Show in home
     *
     * @return $this self Object
     */
    public function setShowInHome($showInHome)
    {
        $this->showInHome = $showInHome;

        return $this;
    }

    /**
     * Get show in home
     *
     * @return boolean Show in home
     */
    public function getShowInHome()
    {
        return $this->showInHome;
    }

    /**
     * Set product manufacturer
     *
     * @param ManufacturerInterface $manufacturer Manufacturer
     *
     * @return $this self Object
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Product manufacturer
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Sets Dimensions
     *
     * @param string $dimensions Dimensions
     *
     * @return ProductInterface Self object
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * Get Dimensions
     *
     * @return string Dimensions
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Gets product SKU
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets product SKU
     *
     * @param string $sku
     *
     * @return $this self Object
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Sets Type
     *
     * @param int $type Type
     *
     * @return $this self Object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get Type
     *
     * @return int Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Adds an attribute if not already in the collection
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this self Object
     */
    public function addAttribute(AttributeInterface $attribute)
    {
        if (!$this->attributes->contains($attribute)) {

            $this->attributes->add($attribute);

        }

        return $this;
    }

    /**
     * Removes an attribute from the collection
     *
     * @param AttributeInterface $attribute Attribute to be removed
     *
     * @return $this self Object
     */
    public function removeAttribute(AttributeInterface $attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * Returns product attributes
     *
     * @return Collection Attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets product attributes
     *
     * @param Collection $attributes Attributes
     *
     * @return $this self Object
     */
    public function setAttributes(Collection $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Gets product variants
     *
     * @return Collection Variants
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Adds a Variant for this Product
     *
     * @param VariantInterface $variant
     *
     * @return $this self Object
     */
    public function addVariant(VariantInterface $variant)
    {
        $this->variants->add($variant);

        return $this;
    }

    /**
     * Sets product variants
     *
     * @param Collection $variants Variants
     *
     * @return $this self Object
     */
    public function setVariants(Collection $variants)
    {
        $this->variants = $variants;

        return $this;
    }

    /**
     * Returns product principal variant
     *
     * @return VariantInterface
     */
    public function getPrincipalVariant()
    {
        return $this->principalVariant;
    }

    /**
     * Sets product principal variant
     *
     * @param VariantInterface $principalVariant
     *
     * @return $this self Object
     */
    public function setPrincipalVariant(VariantInterface $principalVariant)
    {
        $this->principalVariant = $principalVariant;

        return $this;
    }

    /**
     * Tells if this product has variants
     *
     * @return boolean Product has variants
     */
    public function hasVariants()
    {
        return $this->variants->count() > 0;
    }

    /**
     * Product stringified
     *
     * @return string Product in string mode
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
