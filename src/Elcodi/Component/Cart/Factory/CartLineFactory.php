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

namespace Elcodi\Component\Cart\Factory;

use Elcodi\Component\Cart\Entity\CartLine;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class CartLineFactory
 */
class CartLineFactory extends AbstractFactory
{
    /**
     * Creates an instance of CartLine
     *
     * @return CartLine New CartLine entity
     */
    public function create()
    {
        /**
         * @var CartLine $cartLine
         */
        $classNamespace = $this->getEntityNamespace();
        $cartLine = new $classNamespace();

        return $cartLine;
    }
}
