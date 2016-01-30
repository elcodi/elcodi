<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Cart\Entity\Traits;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Trait PurchasableWrapperTrait.
 */
trait PurchasableWrapperTrait
{
    /**
     * @var PurchasableInterface
     *
     * Purchasable
     */
    protected $purchasable;

    /**
     * @var int
     *
     * Quantity
     */
    protected $quantity;

    /**
     * Set the purchasable object.
     *
     * @param PurchasableInterface $purchasable Purchasable object
     *
     * @return $this Self object
     */
    public function setPurchasable(PurchasableInterface $purchasable)
    {
        $this->purchasable = $purchasable;

        return $this;
    }

    /**
     * Gets the purchasable object.
     *
     * @return null|PurchasableInterface Purchasable instance
     */
    public function getPurchasable()
    {
        return $this->purchasable;
    }

    /**
     * Sets quantity.
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Gets quantity.
     *
     * @return int Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
