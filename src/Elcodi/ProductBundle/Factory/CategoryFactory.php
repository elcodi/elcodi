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

namespace Elcodi\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\ProductBundle\Entity\Category;

/**
 * Class CategoryFactory
 */
class CategoryFactory extends AbstractFactory
{
    /**
     * Creates an instance of Category
     *
     * @return Category New Category entity
     */
    public function create()
    {
        /**
         * @var Category $category
         */
        $classNamespace = $this->getEntityNamespace();
        $category = new $classNamespace();
        $category
            ->setSubcategories(new ArrayCollection)
            ->setProducts(new ArrayCollection)
            ->setRoot(false)
            ->setPosition(0)
            ->setEnabled(false)
            ->setCreatedAt(new DateTime);

        return $category;
    }
}
