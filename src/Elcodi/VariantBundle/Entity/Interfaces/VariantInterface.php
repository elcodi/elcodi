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

use Doctrine\Common\Collections\Collection;
use Elcodi\AttributeBundle\Entity\Interfaces\ValueInterface;
use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;
use Elcodi\MediaBundle\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductPriceInterface;

/**
 * Interface VariantInterface
 *
 * A Product variant is a specific combination of finite options
 * for a given Product.
 */
interface VariantInterface extends ProductPriceInterface, EnabledInterface, DateTimeInterface, ImagesContainerInterface
{
    /**
     * Gets the variant SKU
     *
     * @return string
     */
    public function getSku();

    /**
     * Sets the variant SKU
     *
     * @param string $sku
     */
    public function setSku($sku);

    /**
     * Gets the variant stock
     *
     * @return int
     */
    public function getStock();

    /**
     * Sets the variant stock
     *
     * @param int $stock
     */
    public function setStock($stock);

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
     */
    public function setOptions($options);

    /**
     * Adds an option to this variant
     *
     * @param ValueInterface $option
     *
     * @return VariantInterface
     */
    public function addValue(ValueInterface $option);

    /**
     * Removes an option from this variant
     *
     * @param ValueInterface $option
     *
     * @return @return VariantInterface
     */
    public function removeOption(ValueInterface $option);
}
