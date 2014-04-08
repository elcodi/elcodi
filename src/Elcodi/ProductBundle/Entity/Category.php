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

namespace Elcodi\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\ProductBundle\Entity\Traits\MetaDataTrait;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * Category
 */
class Category extends AbstractEntity implements CategoryInterface
{
    use DateTimeTrait, EnabledTrait, MetaDataTrait;

    /**
     * @var string
     *
     * Category name
     */
    protected $name;

    /**
     * @var string
     *
     * Category slug
     */
    protected $slug;

    /**
     * @var Collection
     *
     * Subcategories
     */
    protected $subCategories;

    /**
     * @var Category
     *
     * Parent
     */
    protected $parent;

    /**
     * @var Collection
     *
     * Many-to-Many association between categories
     * and products. The resulting collection could be huge.
     */
    protected $products;

    /**
     * @var bool
     *
     * Category is a root category
     */
    protected $root;

    /**
     * @var Integer
     *
     * Position order to show in menu
     */
    protected $position;

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return CategoryInterface self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return name
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return CategoryInterface self Object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set subcategories
     *
     * @param Collection $subCategories Sub categories
     *
     * @return Category self Object
     */
    public function setSubCategories(Collection $subCategories)
    {
        $this->subCategories = $subCategories;

        return $this;
    }

    /**
     * Get subcategories
     *
     * @return Collection Subcategories
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * Add Subcategory
     *
     * @param CategoryInterface $category Category to add as subcategory
     *
     * @return Category self Object
     */
    public function addSubCategory(CategoryInterface $category)
    {
        $this->subCategories->add($category);

        return $this;
    }

    /**
     * Remove subcategory
     *
     * @param CategoryInterface $category
     *
     * @return Category self Object
     */
    public function removeSubCategory(CategoryInterface $category)
    {
        $this->subCategories->removeElement($category);

        return $this;
    }

    /**
     * Set category parent
     *
     * @param CategoryInterface $parent Category parent
     *
     * @return Category self Object
     */
    public function setParent(CategoryInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get category parent
     *
     * @return CategoryInterface Category parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set products
     *
     * @param Collection $products Products
     *
     * @return Category self Object
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param boolean $root
     *
     * @return Category
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get if is root
     *
     * @return boolean
     */
    public function isRoot()
    {
        return $this->root;
    }

    /**
     * Set position
     *
     * @param Integer $position Category relative position
     *
     * @return Category self Object
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Return Position
     *
     * @return Integer Category relative position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * To string method
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
