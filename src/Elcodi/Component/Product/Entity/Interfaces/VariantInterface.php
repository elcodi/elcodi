<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Component\Media\Entity\Interfaces\PrincipalImageInterface;
use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;

/**
 * Interface VariantInterface
 *
 * A Product variant is a specific combination of finite options
 * for a given Product.
 */
interface VariantInterface
    extends
    IdentifiableInterface,
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function setOptions(Collection $options);

    /**
     * Adds an option to this variant
     *
     * @param ValueInterface $option
     *
     * @return $this Self object
     */
    public function addOption(ValueInterface $option);

    /**
     * Removes an option from this variant
     *
     * @param ValueInterface $option
     *
     * @return $this Self object
     */
    public function removeOption(ValueInterface $option);

    /**
     * Returns variant tax
     *
     * @return TaxInterface
     */
    public function getTax();

    /**
     * Sets variant tax
     *
     * @param TaxInterface $tax
     *
     * @return $this Self object
     */
    public function setTax(TaxInterface $tax);

    /**
     * Returns variant taxed Price
     *
     * @return MoneyInterface
     */
    public function getTaxedPrice();

    /**
     * When a tax is set on the variant      returns a money object with amount = tax amount
     * When a tax is NOT set on the variant  returns a money object with amount = 0
     *
     * @return MoneyInterface
     */
    public function getTaxAmount();
}
