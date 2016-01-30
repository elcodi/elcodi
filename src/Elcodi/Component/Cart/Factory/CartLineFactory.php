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

namespace Elcodi\Component\Cart\Factory;

use Elcodi\Component\Cart\Entity\CartLine;
use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;

/**
 * Class CartLineFactory.
 */
class CartLineFactory extends AbstractPurchasableFactory
{
    /**
     * Creates an instance of CartLine.
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
        $cartLine
            ->setAmount($this->createZeroAmountMoney())
            ->setPurchasableAmount($this->createZeroAmountMoney());

        return $cartLine;
    }
}
