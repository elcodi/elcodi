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

namespace Elcodi\CartBundle\Resolver\Interfaces;

use Elcodi\CartBundle\Entity\Abstracts\AbstractLine;
use Elcodi\ProductBundle\Entity\Interfaces\PurchasableInterface;

/**
 * Interface PurchasableResolverInterface
 *
 * A purchasable resolver allows an object in the AbstracLine
 * class hierarchy to specify the concrete logic to recognize
 * the actual type of a purchasable and to act on the AbstractLine
 * accordingly.
 */
interface PurchasableResolverInterface
{
    /**
     * Sets the purchasable in current line
     *
     * @param PurchasableInterface $purchasable
     */
    public function setPurchasable(PurchasableInterface $purchasable);

    /**
     * Gets the purchasable from current line
     *
     * @return PurchasableInterface
     */
    public function getPurchasable();

    /**
     * PurchasableResolver constructor
     *
     * @param AbstractLine $abstractLine
     */
    public function __construct(AbstractLine $abstractLine);
}
