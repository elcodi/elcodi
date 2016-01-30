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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Cart\Entity\Traits\PurchasableWrapperTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;

/**
 * OrderLine.
 *
 * This entity is just an extension of existant order line with some additional
 * parameters
 */
class OrderLine implements OrderLineInterface
{
    use IdentifiableTrait,
        PurchasableWrapperTrait,
        PriceTrait,
        DimensionsTrait;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * Set Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
