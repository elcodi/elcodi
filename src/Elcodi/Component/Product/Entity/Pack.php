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

namespace Elcodi\Component\Product\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class Pack entity.
 */
class Pack extends Purchasable implements PackInterface
{
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
     * @var CategoryInterface
     *
     * Principal category
     */
    protected $principalCategory;

    /**
     * @var Collection
     *
     * Purchasables
     */
    protected $purchasables;

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
     * Adds an purchasable if not already in the collection.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return $this Self object;
     */
    public function addPurchasable(PurchasableInterface $purchasable)
    {
        $this
            ->purchasables
            ->add($purchasable);

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
        $this
            ->purchasables
            ->removeElement($purchasable);

        return $this;
    }

    /**
     * Returns purchasable purchasables.
     *
     * @return Collection Purchasables
     */
    public function getPurchasables()
    {
        return $this->purchasables;
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
        $this->purchasables = $purchasables;

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
     * Add category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function addCategory(CategoryInterface $category)
    {
        if (!$this
            ->categories
            ->contains($category)
        ) {
            $this
                ->categories
                ->add($category);
        }

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
        $this
            ->categories
            ->removeElement($category);

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
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'purchasable_pack';
    }
}
