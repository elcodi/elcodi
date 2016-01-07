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

/**
 * Interface PackInterface.
 */
interface PackInterface extends PurchasableInterface
{
    /**
     * Adds an purchasable if not already in the collection.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return $this Self object;
     */
    public function addPurchasable(PurchasableInterface $purchasable);

    /**
     * Removes an purchasable from the collection.
     *
     * @param PurchasableInterface $purchasable Purchasable to be removed
     *
     * @return $this Self object
     */
    public function removePurchasable(PurchasableInterface $purchasable);

    /**
     * Returns purchasable purchasables.
     *
     * @return Collection Purchasables
     */
    public function getPurchasables();

    /**
     * Sets purchasable purchasables.
     *
     * @param Collection $purchasables Purchasables
     *
     * @return $this Self object
     */
    public function setPurchasables(Collection $purchasables);

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
     * Set product manufacturer.
     *
     * @param ManufacturerInterface $manufacturer Manufacturer
     *
     * @return $this Self object
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null);

    /**
     * Get product manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer();

    /**
     * Set stock type.
     *
     * @param int $stockType Stock type
     *
     * @return $this Self object
     */
    public function setStockType($stockType);

    /**
     * Get stock type.
     *
     * @return int Stock type
     */
    public function getStockType();
}
