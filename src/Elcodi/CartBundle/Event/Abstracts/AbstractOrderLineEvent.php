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

use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Class AbstractOrderLineEvent
 */
class AbstractOrderLineEvent extends AbstractCartLineEvent
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * construct method
     *
     * @param OrderInterface    $order    Order line
     * @param CartLineInterface $cartLine Cart line
     */
    public function __construct(OrderInterface $order, CartLineInterface $cartLine)
    {
        parent::__construct($cartLine);

        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
