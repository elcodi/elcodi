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

namespace Elcodi\ProductBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;

/**
 * Product manager service
 *
 * Manages common actions on a Product
 */
class ProductManager
{
    /**
     * @var ObjectManager
     *
     * Manager
     */
    protected $manager;

    /**
     * Construct method
     *
     * @param ObjectManager $manager Entity manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Will store the whole category hierarcy for assiciated leaf
     * categories. This will aid the search engine to return
     * products matching leaf category C and *also* the parents
     * of category C (like Car -> Vehicle, if a product is associated
     * to the "Car" category, this will also associate it with the
     * "vehicle" category)
     *
     *  Limitations: this method will only work when using
     *  three-levels categories.
     *
     *  TODO: generalize the method to work with any category depth
     *
     *  Such as while ($c = $c->getParent()) {} or so.
     *
     * @param ProductInterface $product Product to process
     *
     * @return ProductManager self Object
     */
    public function loadProductCategoryHierarchy(ProductInterface $product)
    {
        $categories = $product->getCategories();
        $newCategories = new ArrayCollection();

        foreach ($categories as $category) {

            /**
             * @var CategoryInterface $category
             */
            if (!$category->isEnabled()) {
                continue;
            }

            // we will collect the associated ctegories here
            // and later will just set this whole collection
            // to current Product entity
            $newCategories->add($category);

            // a recursive function is needed to walk the variable-depth category hierarchy
            $newCategories = new ArrayCollection(
                array_merge(
                    $newCategories->toArray(),
                    $this->addRecursiveParentCategories($category)->toArray()
                )
            );

            $categoriesId = array();

            // let's filter out duplicated categories
            $newCategories = $newCategories->filter(
                function ($category) use (&$categoriesId) {
                    /**
                     * @var Category $category
                     */
                    if (in_array($category->getId(), $categoriesId)) {
                        return false;
                    }

                    $categoriesId[] = $category->getId();

                    return true;
                }
            );

        }

        $product->setCategories($newCategories);
        $this->manager->flush($product);

        return $this;
    }

    /**
     * Starting from a leaf category, recurs the hierarchy for the
     * specified category up to the root and return the found nodes
     *
     * @param CategoryInterface $category   Category
     * @param Collection        $foundNodes Found nodes
     *
     * @return Collection
     */
    protected function addRecursiveParentCategories(CategoryInterface $category, Collection $foundNodes = null)
    {
        $foundNodes = $foundNodes
            ? $foundNodes
            : array();

        if (!$category) {
            return $foundNodes;
        }

        $foundNodes = array_merge(
            $foundNodes,
            $this->addRecursiveParentCategories($category->getParent(), $foundNodes)
        );

        if ($category->isEnabled()) {

            $foundNodes[] = $category;
        }

        return $foundNodes;
    }
}
