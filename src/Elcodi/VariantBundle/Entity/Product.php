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

namespace Elcodi\VariantBundle\Entity;

use Elcodi\ProductBundle\Entity\Product as BaseProduct;
use Elcodi\VariantBundle\Entity\Interfaces\ProductInterface;

class Product extends BaseProduct implements ProductInterface
{
    protected $attributes;

    protected $variants;

    protected $principalVariant;

    public function getPrincipalVariant()
    {

    }

    /**
     * @param mixed $principalVariant
     */
    public function setPrincipalVariant($principalVariant)
    {
        $this->principalVariant = $principalVariant;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param mixed $variants
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;

        return $this;
    }

} 