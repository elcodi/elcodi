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

namespace Elcodi\Component\Product\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Product\Entity\Category;

/**
 * Class CategoryFactory.
 */
class CategoryFactory extends AbstractFactory
{
    /**
     * Creates an instance of Category.
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
            ->setSubcategories(new ArrayCollection())
            ->setRoot(true)
            ->setPosition(0)
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $category;
    }
}
