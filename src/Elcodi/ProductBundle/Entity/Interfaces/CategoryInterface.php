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

/**
 * Class CategoryInterface
 */
interface CategoryInterface extends MetaDataInterface, EnabledInterface
{
    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return CategoryInterface self Object
     */
    public function setName($name);

    /**
     * Return name
     *
     * @return string name
     */
    public function getName();

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return CategoryInterface self Object
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string Slug
     */
    public function getSlug();

    /**
     * Set subcategories
     *
     * @param Collection $subCategories Sub categories
     *
     * @return CategoryInterface self Object
     */
    public function setSubCategories(Collection $subCategories);

    /**
     * Get subcategories
     *
     * @return Collection Subcategories
     */
    public function getSubCategories();

    /**
     * Add Subcategory
     *
     * @param CategoryInterface $category Category to add as subcategory
     *
     * @return CategoryInterface self Object
     */
    public function addSubCategory(CategoryInterface $category);

    /**
     * Remove subcategory
     *
     * @param CategoryInterface $category
     *
     * @return CategoryInterface self Object
     */
    public function removeSubCategory(CategoryInterface $category);

    /**
     * Set category parent
     *
     * @param CategoryInterface $parent Category parent
     *
     * @return CategoryInterface self Object
     */
    public function setParent(CategoryInterface $parent = null);

    /**
     * Get category parent
     *
     * @return CategoryInterface Category parent
     */
    public function getParent();

    /**
     * Set products
     *
     * @param Collection $products Products
     *
     * @return CategoryInterface self Object
     */
    public function setProducts(Collection $products);

    /**
     * Get products
     *
     * @return Collection
     */
    public function getProducts();

    /**
     * @param boolean $root
     *
     * @return CategoryInterface
     */
    public function setRoot($root);

    /**
     * Get if is root
     *
     * @return boolean
     */
    public function isRoot();

    /**
     * Set position
     *
     * @param Integer $position Category relative position
     *
     * @return CategoryInterface self Object
     */
    public function setPosition($position);

    /**
     * Return Position
     *
     * @return Integer Category relative position
     */
    public function getPosition();
}
