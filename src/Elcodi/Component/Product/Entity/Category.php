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

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class Category.
 */
class Category implements CategoryInterface
{
    use IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait,
        MetaDataTrait;

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
     * @var CategoryInterface
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
    protected $purchasables;

    /**
     * @var bool
     *
     * Category is a root category
     */
    protected $root;

    /**
     * @var int
     *
     * Position order to show in menu
     */
    protected $position;

    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return name.
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set subcategories.
     *
     * @param Collection $subCategories Sub categories
     *
     * @return $this Self object
     */
    public function setSubCategories(Collection $subCategories)
    {
        $this->subCategories = $subCategories;

        return $this;
    }

    /**
     * Get subcategories.
     *
     * @return Collection Subcategories
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * Add Subcategory.
     *
     * @param CategoryInterface $category Category to add as subcategory
     *
     * @return $this Self object
     */
    public function addSubCategory(CategoryInterface $category)
    {
        if (!$this
            ->subCategories
            ->contains($category)
        ) {
            $this
                ->subCategories
                ->add($category);
        }

        return $this;
    }

    /**
     * Remove subcategory.
     *
     * @param CategoryInterface $category
     *
     * @return $this Self object
     */
    public function removeSubCategory(CategoryInterface $category)
    {
        $this
            ->subCategories
            ->removeElement($category);

        return $this;
    }

    /**
     * Set category parent.
     *
     * @param CategoryInterface|null $parent Category parent
     *
     * @return $this Self object
     */
    public function setParent(CategoryInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get category parent.
     *
     * @return CategoryInterface Category parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param bool $root
     *
     * @return $this Self object
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get if is root.
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->root;
    }

    /**
     * Set position.
     *
     * @param int $position Category relative position
     *
     * @return $this Self object
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Return Position.
     *
     * @return int Category relative position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get purchasables.
     *
     * @return Collection
     */
    public function getPurchasables()
    {
        return $this->purchasables;
    }

    /**
     * To string method.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
