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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Class CategoryInterface
 */
interface CategoryInterface
    extends
    IdentifiableInterface,
    MetaDataInterface,
    EnabledInterface
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function addSubCategory(CategoryInterface $category);

    /**
     * Remove subcategory
     *
     * @param CategoryInterface $category
     *
     * @return $this Self object
     */
    public function removeSubCategory(CategoryInterface $category);

    /**
     * Set category parent
     *
     * @param CategoryInterface $parent Category parent
     *
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function setPosition($position);

    /**
     * Return Position
     *
     * @return Integer Category relative position
     */
    public function getPosition();
}
