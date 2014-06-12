<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Factory;

use Elcodi\CartBundle\Entity\CartLine;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

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
