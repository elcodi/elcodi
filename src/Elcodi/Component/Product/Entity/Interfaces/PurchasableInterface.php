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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\ETaggableInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Interface PurchasableInterface.
 *
 * a Purchasable is an object that:
 *
 * * Has a SKU (Stock Keeping Unit) code
 * * Has stock attribute, reporting the purchasable availability.
 * * Implements ProductPriceInterface, so that prices can be read and written
 *
 * Using this consistent interface, services and classes that operate on
 * these features (such as CartManager) will have a shallow dependency
 * with more concrete product classes or interfaces
 */
interface PurchasableInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    ETaggableInterface,
    MetaDataInterface,
    ImagesContainerWithPrincipalImageInterface,
    EnabledInterface,
    PurchasablePriceInterface,
    DimensionableInterface
{
    /**
     * Gets the variant SKU.
     *
     * @return string
     */
    public function getSku();

    /**
     * Sets the variant SKU.
     *
     * @param string $sku
     *
     * @return $this Self object
     */
    public function setSku($sku);

    /**
     * Get Slug.
     *
     * @return string Slug
     */
    public function getSlug();

    /**
     * Sets Slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug);

    /**
     * Gets the variant stock.
     *
     * @return int stock
     */
    public function getStock();

    /**
     * Sets the variant stock.
     *
     * @param int $stock
     *
     * @return $this Self object
     */
    public function setStock($stock);

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get ShortDescription.
     *
     * @return string ShortDescription
     */
    public function getShortDescription();

    /**
     * Sets ShortDescription.
     *
     * @param string $shortDescription ShortDescription
     *
     * @return $this Self object
     */
    public function setShortDescription($shortDescription);

    /**
     * Get Description.
     *
     * @return string Description
     */
    public function getDescription();

    /**
     * Sets Description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * Get ShowInHome.
     *
     * @return bool ShowInHome
     */
    public function getShowInHome();

    /**
     * Sets ShowInHome.
     *
     * @param bool $showInHome ShowInHome
     *
     * @return $this Self object
     */
    public function setShowInHome($showInHome);

    /**
     * Get Dimensions.
     *
     * @return string Dimensions
     */
    public function getDimensions();

    /**
     * Sets Dimensions.
     *
     * @param string $dimensions Dimensions
     *
     * @return $this Self object
     */
    public function setDimensions($dimensions);

    /**
     * Set the height.
     *
     * @param int $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height);

    /**
     * Set the width.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Set the depth.
     *
     * @param int $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth);

    /**
     * Set the weight.
     *
     * @param int $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight);

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories();

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory();

    /**
     * Product manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer();

    /**
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType();
}
