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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\ETaggableInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Interface ProductInterface.
 */
interface ProductInterface
    extends
    IdentifiableInterface,
    PurchasableInterface,
    DateTimeInterface,
    ETaggableInterface,
    MetaDataInterface,
    ImagesContainerWithPrincipalImageInterface
{
    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug);

    /**
     * Get slug.
     *
     * @return string slug
     */
    public function getSlug();

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * Get description.
     *
     * @return string Description
     */
    public function getDescription();

    /**
     * Set short description.
     *
     * @param string $shortDescription Short description
     *
     * @return $this Self object
     */
    public function setShortDescription($shortDescription);

    /**
     * Get short description.
     *
     * @return string Short description
     */
    public function getShortDescription();

    /**
     * Set categories.
     *
     * @param Collection $categories Categories
     *
     * @return $this Self object
     */
    public function setCategories(Collection $categories);

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories();

    /**
     * Add category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function addCategory(CategoryInterface $category);

    /**
     * Remove category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function removeCategory(CategoryInterface $category);

    /**
     * Set the principalCategory.
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return $this Self object
     */
    public function setPrincipalCategory(CategoryInterface $principalCategory = null);

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory();

    /**
     * Set show in home.
     *
     * @param bool $showInHome Show in home
     *
     * @return $this Self object
     */
    public function setShowInHome($showInHome);

    /**
     * Get show in home.
     *
     * @return bool Show in home
     */
    public function getShowInHome();

    /**
     * Set product manufacturer.
     *
     * @param ManufacturerInterface $manufacturer Manufacturer
     *
     * @return $this Self object
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null);

    /**
     * Product manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer();

    /**
     * Returns product principal variant.
     *
     * @return VariantInterface
     */
    public function getPrincipalVariant();

    /**
     * Sets product principal variant.
     *
     * @param VariantInterface $principalVariant
     *
     * @return $this Self object
     */
    public function setPrincipalVariant(VariantInterface $principalVariant);

    /**
     * Adds an attribute if not already in the collection.
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this Self object;
     */
    public function addAttribute(AttributeInterface $attribute);

    /**
     * Removes an attribute from the collection.
     *
     * @param AttributeInterface $attribute Attribute to be removed
     *
     * @return $this Self object
     */
    public function removeAttribute(AttributeInterface $attribute);

    /**
     * Returns product attributes.
     *
     * @return Collection Attributes
     */
    public function getAttributes();

    /**
     * Sets product attributes.
     *
     * @param Collection $attributes Attributes
     *
     * @return $this Self object
     */
    public function setAttributes(Collection $attributes);

    /**
     * Gets product variants.
     *
     * @return Collection Variants
     */
    public function getVariants();

    /**
     * Adds a Variant for this Product.
     *
     * @param VariantInterface $variant Variant
     *
     * @return $this Self object
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Sets product variants.
     *
     * @param Collection $variants Variants
     *
     * @return $this Self object
     */
    public function setVariants(Collection $variants);

    /**
     * Tells if this product has variants.
     *
     * @return bool Product has variants
     */
    public function hasVariants();
}
