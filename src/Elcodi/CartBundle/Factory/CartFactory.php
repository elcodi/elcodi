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
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;

/**
 * Class CartFactory
 */
class CartFactory extends AbstractFactory
{
    /**
     * @var CurrencyWrapper
     *
     * Currency wrapper
     */
    protected $currencyWrapper;

    /**
     * Set the Currency wrapper
     *
     * @param CurrencyWrapper $currencyWrapper
     */
    public function setCurrencyWrapper(
        CurrencyWrapper $currencyWrapper
    )
    {
        $this->currencyWrapper = $currencyWrapper;
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
            ->setCurrency($this->currencyWrapper->loadCurrency())
            ->setCreatedAt(new DateTime);

        return $cart;
    }
}
