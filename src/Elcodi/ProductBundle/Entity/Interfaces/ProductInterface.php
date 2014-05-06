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

namespace Elcodi\ProductBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;
use Elcodi\CoreBundle\Entity\Interfaces\ETaggableInterface;
use Elcodi\MediaBundle\Entity\Interfaces\ImagesContainerInterface;

/**
 * Class ProductInterface
 */
interface ProductInterface extends EnabledInterface, ETaggableInterface, MetaDataInterface, ImagesContainerInterface
{
    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return ProductInterface self Object
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return ProductInterface self Object
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string slug
     */
    public function getSlug();

    /**
     * @param string $description
     *
     * @return ProductInterface self Object
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string Description
     */
    public function getDescription();

    /**
     * Set short description
     *
     * @param string $shortDescription Short description
     *
     * @return ProductInterface self Object
     */
    public function setShortDescription($shortDescription);

    /**
     * Get short description
     *
     * @return string Short description
     */
    public function getShortDescription();

    /**
     * Set categories
     *
     * @param Collection $categories Categories
     *
     * @return ProductInterface self Object
     */
    public function setCategories(Collection $categories);

    /**
     * Get categories
     *
     * @return Collection Categories
     */
    public function getCategories();

    /**
     * Add category
     *
     * @param CategoryInterface $category Category
     *
     * @return ProductInterface self Object
     */
    public function addCategory(CategoryInterface $category);

    /**
     * Remove category
     *
     * @param CategoryInterface $category Category
     *
     * @return ProductInterface self Object
     */
    public function removeCategory(CategoryInterface $category);

    /**
     * Set the principalCategory
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return ProductInterface self Object
     */
    public function setPrincipalCategory(CategoryInterface $principalCategory = null);

    /**
     * Get the principalCategory
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory();

    /**
     * Set stock
     *
     * @param int $stock Stock
     *
     * @return ProductInterface self Object
     */
    public function setStock($stock);

    /**
     * Get stock
     *
     * @return int Stock
     */
    public function getStock();

    /**
     * Set price
     *
     * @param float $price Price
     *
     * @return ProductInterface self Object
     */
    public function setPrice($price);

    /**
     * Get price
     *
     * @return float Price
     */
    public function getPrice();

    /**
     * Set price
     *
     * @param float $reducedPrice Reduced Price
     *
     * @return ProductInterface self Object
     */
    public function setReducedPrice($reducedPrice);

    /**
     * Get price
     *
     * @return float Reduced Price
     */
    public function getReducedPrice();

    /**
     * Set show in home
     *
     * @param boolean $showInHome Show in home
     *
     * @return ProductInterface self Object
     */
    public function setShowInHome($showInHome);

    /**
     * Get show in home
     *
     * @return boolean Show in home
     */
    public function getShowInHome();

    /**
     * Set product manufacturer
     *
     * @param ManufacturerInterface $manufacturer Manufacturer
     *
     * @return ProductInterface self Object
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null);

    /**
     * Product manufacuter
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer();
}
