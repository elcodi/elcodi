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
     * @return $this Self object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function addCategory(CategoryInterface $category);

    /**
     * Remove category
     *
     * @param CategoryInterface $category Category
     *
     * @return $this self Object
     */
    public function removeCategory(CategoryInterface $category);

    /**
     * Set the principalCategory
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function setPrincipalVariant(VariantInterface $principalVariant);

    /**
     * Adds an attribute if not already in the collection
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this self Object;
     */
    public function addAttribute(AttributeInterface $attribute);

    /**
     * Removes an attribute from the collection
     *
     * @param AttributeInterface $attribute Attribute to be removed
     *
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Sets product variants
     *
     * @param Collection $variants Variants
     *
     * @return $this self Object
     */
    public function setVariants(Collection $variants);

    /**
     * Tells if this product has variants
     *
     * @return boolean Product has variants
     */
    public function hasVariants();
}
