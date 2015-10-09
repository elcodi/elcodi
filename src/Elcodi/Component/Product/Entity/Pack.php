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

namespace Elcodi\Component\Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ETaggableTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\Product\Entity\Traits\ProductPriceTrait;

/**
 * Class Pack entity.
 */
class Pack implements PackInterface
{
    use IdentifiableTrait,
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
     * Pack SKU
     */
    protected $sku;

    /**
     * @var int
     *
     * Pack type
     */
    protected $type;

    /**
     * @var int
     *
     * Stock Type
     */
    protected $stockType;

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
     * @var ManufacturerInterface
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
     * @var bool
     *
     * Pack must show in home
     */
    protected $showInHome;

    /**
     * @var string
     *
     * Pack dimensions
     */
    protected $dimensions;

    /**
     * @var Collection
     *
     * Products
     */
    protected $products;

    /**
     * @var Collection
     *
     * Variants
     */
    protected $variants;

    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set short description.
     *
     * @param string $shortDescription Short description
     *
     * @return $this Self object
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get short description.
     *
     * @return string Short description
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set stock type.
     *
     * @param int $stockType Stock type
     *
     * @return $this Self object
     */
    public function setStockType($stockType)
    {
        $this->stockType = $stockType;

        return $this;
    }

    /**
     * Get stock type.
     *
     * @return int Stock type
     */
    public function getStockType()
    {
        return $this->stockType;
    }

    /**
     * Set stock.
     *
     * @param int $stock Stock
     *
     * @return $this Self object
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock.
     *
     * @return int Stock
     */
    public function getStock()
    {
        if ($this->getStockType() !== ElcodiProductStock::INHERIT_STOCK) {
            return $this->stock;
        }

        $stock = ElcodiProductStock::INFINITE_STOCK;
        foreach ($this->getPurchasables() as $purchasable) {
            $purchasableStock = $purchasable->getStock();
            if (is_int($purchasableStock) && (
                    !is_int($stock) ||
                    $purchasableStock < $stock
                )) {
                $stock = $purchasableStock;
            }
        }

        return $stock;
    }

    /**
     * Set show in home.
     *
     * @param bool $showInHome Show in home
     *
     * @return $this Self object
     */
    public function setShowInHome($showInHome)
    {
        $this->showInHome = $showInHome;

        return $this;
    }

    /**
     * Get show in home.
     *
     * @return bool Show in home
     */
    public function getShowInHome()
    {
        return $this->showInHome;
    }

    /**
     * Sets Dimensions.
     *
     * @param string $dimensions Dimensions
     *
     * @return $this Self object
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * Get Dimensions.
     *
     * @return string Dimensions
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Gets Pack SKU.
     *
     * @return string Pack SKU
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets Pack SKU.
     *
     * @param string $sku
     *
     * @return $this Self object
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Sets Type.
     *
     * @param int $type Type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get Type.
     *
     * @return int Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Initializes purchasables.
     *
     * @return $this Self object
     */
    public function initializePurchasable()
    {
        $this->products = new ArrayCollection();
        $this->variants = new ArrayCollection();

        return $this;
    }

    /**
     * Adds an purchasable if not already in the collection.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return $this Self object;
     */
    public function addPurchasable(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ProductInterface) {
            $this->products->add($purchasable);
        }

        if ($purchasable instanceof VariantInterface) {
            $this->variants->add($purchasable);
        }

        return $this;
    }

    /**
     * Removes an purchasable from the collection.
     *
     * @param PurchasableInterface $purchasable Purchasable to be removed
     *
     * @return $this Self object
     */
    public function removePurchasable(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ProductInterface) {
            $this->products->removeElement($purchasable);
        }

        if ($purchasable instanceof VariantInterface) {
            $this->variants->removeElement($purchasable);
        }
    }

    /**
     * Returns purchasable purchasables.
     *
     * @param Collection $emptyCollection Empty collection
     *
     * @return Collection Purchasables
     */
    public function getPurchasables()
    {
        return new ArrayCollection(
            array_merge(
                $this->products->toArray(),
                $this->variants->toArray()
            )
        );
    }

    /**
     * Sets purchasable purchasables.
     *
     * @param Collection $purchasables Purchasables
     *
     * @return $this Self object
     */
    public function setPurchasables(Collection $purchasables)
    {
        $this->initializePurchasable();

        foreach ($purchasables as $purchasable) {
            $this->addPurchasable($purchasable);
        }

        return $this;
    }

    /**
     * Get Products.
     *
     * @return Collection Products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Sets Products.
     *
     * @param Collection $products Products
     *
     * @return $this Self object
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get Variants.
     *
     * @return Collection Variants
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Sets Variants.
     *
     * @param Collection $variants Variants
     *
     * @return $this Self object
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;

        return $this;
    }

    /**
     * Set categories.
     *
     * @param Collection $categories Categories
     *
     * @return $this Self object
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function addCategory(CategoryInterface $category)
    {
        $this->categories->add($category);

        return $this;
    }

    /**
     * Remove category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function removeCategory(CategoryInterface $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * Set the principalCategory.
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return $this Self object
     */
    public function setPrincipalCategory(CategoryInterface $principalCategory = null)
    {
        $this->principalCategory = $principalCategory;

        return $this;
    }

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory()
    {
        return $this->principalCategory;
    }

    /**
     * Set product manufacturer.
     *
     * @param ManufacturerInterface $manufacturer Manufacturer
     *
     * @return $this Self object
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Product manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Pack stringified.
     *
     * @return string Pack in string mode
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
