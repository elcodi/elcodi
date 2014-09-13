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

namespace Elcodi\Component\Cart\Resolver\Interfaces;

use Elcodi\Component\Cart\Entity\Abstracts\AbstractLine;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

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
     * PurchasableResolver constructor
     *
     * @param AbstractLine $abstractLine Line
     */
    public function __construct(AbstractLine $abstractLine);

    /**
     * Sets the purchasable in current line
     *
     * @param PurchasableInterface $purchasable Purchasable object
     *
     * @return $this self Object
     */
    public function setPurchasable(PurchasableInterface $purchasable);

    /**
     * Gets the purchasable from current line
     *
     * @return PurchasableInterface Purchasable object
     */
    public function getPurchasable();
}
