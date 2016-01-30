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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;

/**
 * Interface OrderLineInterface.
 */
interface OrderLineInterface
    extends
    IdentifiableInterface,
    PurchasableWrapperInterface,
    PriceInterface,
    DimensionableInterface
{
    /**
     * Set Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Set the height.
     *
     * @param int $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height);

    /**
     * Set the width.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Set the depth.
     *
     * @param int $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth);

    /**
     * Set the weight.
     *
     * @param int $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight);
}
