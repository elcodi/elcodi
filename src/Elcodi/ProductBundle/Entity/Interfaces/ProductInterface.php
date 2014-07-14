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

namespace Elcodi\ProductBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\ETaggableInterface;
use Elcodi\MediaBundle\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;

/**
 * Class ProductInterface
 */
interface ProductInterface extends PurchasableInterface, ETaggableInterface, MetaDataInterface, ImagesContainerInterface
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

    /**
     * Returns product principal variant
     *
     * @return VariantInterface
     */
    public function getPrincipalVariant();

    /**
     * Sets product principal variant
     *
     * @param VariantInterface $principalVariant
     *
     * @return ProductInterface
     */
    public function setPrincipalVariant(VariantInterface $principalVariant);

    /**
     * Returns product attributes
     *
     * @return Collection
     */
    public function getAttributes();

    /**
     * Sets product attributes
     *
     * @param Collection $attributes
     *
     * @return ProductInterface
     */
    public function setAttributes(Collection $attributes);

    /**
     * Gets product variants
     *
     * @return Collection
     */
    public function getVariants();

    /**
     * Adds a Variant for this Product
     *
     * @param VariantInterface $variant
     *
     * @return ProductInterface
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Sets product variants
     *
     * @param Collection $variants
     *
     * @return ProductInterface
     */
    public function setVariants(Collection $variants);

    /**
     * Tells if this product has variants
     *
     * @return bool
     */
    public function hasVariants();
}
