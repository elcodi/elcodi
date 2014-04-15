<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Class AbstractOrderEvent
 */
class AbstractOrderEvent extends Event
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * construct method
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order The order created
     */
    public function __construct(CartInterface $cart, OrderInterface $order)
    {
        parent::__construct($cart);

        $this->order = $order;
    }

    /**
     * Return order stored
     *
     * @return OrderInterface Order stored
     */
    public function getOrder()
    {
        return $this->order;
    }
}
