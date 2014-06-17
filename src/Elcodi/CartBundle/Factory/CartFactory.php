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

namespace Elcodi\CartBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

use Elcodi\CartBundle\Entity\Cart;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class CartFactory
 */
class CartFactory extends AbstractFactory
{
    /**
     * Creates an instance of Cart
     *
     * @return Cart New Cart entity
     */
    public function create()
    {
        /**
         * @var Cart $cart
         */
        $classNamespace = $this->getEntityNamespace();
        $cart = new $classNamespace();
        $cart
            ->setQuantity(0)
            ->setOrdered(false)
            ->setCartLines(new ArrayCollection)
            ->setCreatedAt(new DateTime);

        return $cart;
    }
}
