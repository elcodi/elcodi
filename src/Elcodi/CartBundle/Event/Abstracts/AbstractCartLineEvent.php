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

/**
 * Class AbstractCartLineEvent
 */
abstract class AbstractCartLineEvent extends AbstractPurchaseEvent
{
    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    protected $cartLine;

    /**
     * Construct method
     *
     * @param CartLineInterface $cartLine Cart line
     */
    public function __construct(CartLineInterface $cartLine)
    {
        $this->cart = $cartLine;
    }

    /**
     * Get cartLine
     *
     * @return CartLineInterface $cartLine
     */
    public function getCart()
    {
        return $this->cartLine;
    }
}
