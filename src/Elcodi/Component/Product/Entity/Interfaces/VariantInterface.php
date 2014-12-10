<?php

/*
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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Component\Media\Entity\Interfaces\PrincipalImageInterface;

/**
 * Interface VariantInterface
 *
 * A Product variant is a specific combination of finite options
 * for a given Product.
 */
interface VariantInterface
    extends
    PurchasableInterface,
    DateTimeInterface,
    ImagesContainerInterface,
    PrincipalImageInterface
{
    /**
     * Set id
     *
     * @param string $id Id
     *
     * @return self
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return string Id
     */
    public function getId();

    /**
     * Gets parent product
     *
     * @return ProductInterface Product
     */
    public function getProduct();

    /**
     * Sets parent product
     *
     * @param ProductInterface $product
     *
     * @return self
     */
    public function setProduct($product);

    /**
     * Gets this variant option values
     *
     * @return Collection Variant options
     */
    public function getOptions();

    /**
     * Sets this variant option values
     *
     * @param Collection $options
     *
     * @return self
     */
    public function setOptions(Collection $options);

    /**
     * Adds an option to this variant
     *
     * @param ValueInterface $option
     *
     * @return self
     */
    public function addOption(ValueInterface $option);

    /**
     * Removes an option from this variant
     *
     * @param ValueInterface $option
     *
     * @return self
     */
    public function removeOption(ValueInterface $option);
}
