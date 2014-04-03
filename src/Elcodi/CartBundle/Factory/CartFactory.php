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
            ->setCartLines(new ArrayCollection)
            ->setCreatedAt(new DateTime);

        return $cart;
    }
}
