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
use Elcodi\ProductBundle\Entity\Product;

/**
 * Class ProductFactory
 */
class ProductFactory extends AbstractFactory
{
    /**
     * Creates an instance of Product
     *
     * @return Product New Product entity
     */
    public function create()
    {
        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
        $product = new $classNamespace();
        $product
            ->setStock(0)
            ->setPrice(0.0)
            ->setReducedPrice(0.0)
            ->setShowInHome(false)
            ->setCategories(new ArrayCollection)
            ->setImages(new ArrayCollection())
            ->setEnabled(false)
            ->setCreatedAt(new DateTime);

        return $product;
    }
}
