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

namespace Elcodi\ProductBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;
use Elcodi\AttributeBundle\Entity\Interfaces\ValueInterface;
use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\MediaBundle\Entity\Interfaces\ImagesContainerInterface;

/**
 * Interface VariantInterface
 *
 * A Product variant is a specific combination of finite options
 * for a given Product.
 */
interface VariantInterface extends PurchasableInterface, DateTimeInterface, ImagesContainerInterface
{
    /**
     * Gets parent product
     *
     * @return ProductInterface
     */
    public function getProduct();

    /**
     * Sets parent product
     *
     * @param ProductInterface $product
     *
     * @return VariantInterface
     */
    public function setProduct($product);

    /**
     * Gets this variant option values
     *
     * @return Collection
     */
    public function getOptions();

    /**
     * Sets this variant option values
     *
     * @param Collection $options
     *
     * @return VariantInterface
     */
    public function setOptions($options);

    /**
     * Adds an option to this variant
     *
     * @param ValueInterface $option
     *
     * @return VariantInterface
     */
    public function addOption(ValueInterface $option);

    /**
     * Removes an option from this variant
     *
     * @param ValueInterface $option
     *
     * @return @return VariantInterface
     */
    public function removeOption(ValueInterface $option);
}
