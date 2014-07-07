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

namespace Elcodi\VariantBundle\Entity\Interfaces;

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface as BaseProductInterface;

interface ProductInterface extends BaseProductInterface
{
    public function getPrincipalVariant();

    /**
     * @param mixed $principalVariant
     */
    public function setPrincipalVariant($principalVariant);

    /**
     * @return mixed
     */
    public function getAttributes();

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes);

    /**
     * @return mixed
     */
    public function getVariants();

    /**
     * @param mixed $variants
     */
    public function setVariants($variants);
} 