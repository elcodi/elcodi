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

/**
 * Interface CategorizableInterface.
 */
interface CategorizableInterface
{
    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories();

    /**
     * Set categories.
     *
     * @param Collection $categories Categories
     *
     * @return $this Self object
     */
    public function setCategories(Collection $categories);

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
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory();

    /**
     * Set the principalCategory.
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return $this Self object
     */
    public function setPrincipalCategory(CategoryInterface $principalCategory = null);
}
