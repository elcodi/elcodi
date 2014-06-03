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
use Elcodi\CurrencyBundle\Factory\CurrencyFactory;

/**
 * Class CartFactory
 */
class CartFactory extends AbstractFactory
{
    /**
     * Factory for creating an empty Currency
     *
     * @var CurrencyFactory
     */
    protected $currencyFactory;

    /**
     * Set the Currency factory
     *
     * @param CurrencyFactory $currencyFactory
     */
    public function setCurrencyFactory(CurrencyFactory $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;
    }

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
            ->setCurrency($this->currencyFactory->create())
            ->setCreatedAt(new DateTime);

        return $cart;
    }
}
