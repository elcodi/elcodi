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

namespace Elcodi\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ManufacturerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\ProductBundle\Entity\Traits\MetaDataTrait;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\ETaggableTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\MediaBundle\Entity\Traits\ImagesContainerTrait;

/**
 * Product entity
 */
class Product extends AbstractEntity implements ProductInterface
{
    use DateTimeTrait, EnabledTrait, ETaggableTrait, MetaDataTrait, ImagesContainerTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

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
     * @var int
     *
     * Stock
     */
    protected $stock;

    /**
     * @var float
     *
     * Product price
     */
    protected $price;

    /**
     * @var float
     *
     * Reduced price
     */
    protected $reducedPrice;

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
     * Set name
     *
     * @param string $name Name
     *
     * @return Product self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
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
     * @return Product self Object
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
     * @param string $description
     *
     * @return Product self Object
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
     * @return Product self Object
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
     * @return Product self Object
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
     * @return Product self Object
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
     * @return Product self Object
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
     * @return Product self Object
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
     * @return Product self Object
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
     * Set price
     *
     * @param float $price Price
     *
     * @return Product self Object
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $reducedPrice Reduced Price
     *
     * @return Product self Object
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;

        return $this;
    }

    /**
     * Get price
     *
     * @return float Reduced Price
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * Set show in home
     *
     * @param boolean $showInHome Show in home
     *
     * @return Product self Object
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
     * @return Product self Object
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
     * Product stringified
     *
     * @return string Product in string mode
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
