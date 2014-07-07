<?php

/**
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
 */

namespace Elcodi\VariantBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\VariantBundle\Entity\Product;
use Elcodi\VariantBundle\Entity\Variant;

/**
 * Factory for Attribute entities
 */
class ProductFactory extends AbstractFactory
{
    /**
     * Creates an Attribute instance
     *
     * @return Variant New Attribute entity
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
            ->setShowInHome(false)
            ->setCategories(new ArrayCollection)
            ->setVariants(new ArrayCollection())
            ->setAttributes(new ArrayCollection())
            ->setImages(new ArrayCollection())
            ->setEnabled(false)
            ->setCreatedAt(new \DateTime);

        return $product;
    }
}
