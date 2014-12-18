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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Core\Entity\Interfaces\ETaggableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Component\Media\Entity\Interfaces\PrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Class ProductInterface
 */
interface ProductInterface
    extends
    PurchasableInterface,
    ETaggableInterface,
    MetaDataInterface,
    ImagesContainerInterface,
    PrincipalImageInterface
{

    /**
     * Set id
     *
     * @param string $id Id
     *
     * @return self
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return string Id
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function addCategory(CategoryInterface $category);

    /**
     * Remove category
     *
     * @param CategoryInterface $category Category
     *
     * @return self
     */
    public function removeCategory(CategoryInterface $category);

    /**
     * Set the principalCategory
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null);

    /**
     * Product manufacturer
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
     * @return self
     */
    public function setPrincipalVariant(VariantInterface $principalVariant);

    /**
     * Adds an attribute if not already in the collection
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return self;
     */
    public function addAttribute(AttributeInterface $attribute);

    /**
     * Removes an attribute from the collection
     *
     * @param AttributeInterface $attribute Attribute to be removed
     *
     * @return self
     */
    public function removeAttribute(AttributeInterface $attribute);

    /**
     * Returns product attributes
     *
     * @return Collection Attributes
     */
    public function getAttributes();

    /**
     * Sets product attributes
     *
     * @param Collection $attributes Attributes
     *
     * @return self
     */
    public function setAttributes(Collection $attributes);

    /**
     * Gets product variants
     *
     * @return Collection Variants
     */
    public function getVariants();

    /**
     * Adds a Variant for this Product
     *
     * @param VariantInterface $variant Variant
     *
     * @return self
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Sets product variants
     *
     * @param Collection $variants Variants
     *
     * @return self
     */
    public function setVariants(Collection $variants);

    /**
     * Tells if this product has variants
     *
     * @return boolean Product has variants
     */
    public function hasVariants();
}
