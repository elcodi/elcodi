<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Cart\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;

/**
 * Class CartEmptyShippingEventListener
 */
class CartEmptyShippingEventListener
{
    /**
     * @var EmptyMoneyWrapper
     *
     * Empty Money Wrapper
     */
    private $emptyMoneyWrapper;

    /**
     * Construct
     *
     * @param EmptyMoneyWrapper $emptyMoneyWrapper Empty money wrapper
     */
    public function __construct(EmptyMoneyWrapper $emptyMoneyWrapper)
    {
        $this->emptyMoneyWrapper = $emptyMoneyWrapper;
    }

    /**
     * If the cart's shipping amount is not defined, then put an empty Money
     * value
     *
     * @param CartOnLoadEvent $event Event
     *
     * @return $this Self object
     */
    public function checkEmptyShippingAmount(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        if (!($cart->getShippingAmount() instanceof Money)) {
            $cart
                ->setShippingAmount(
                    $this
                        ->emptyMoneyWrapper
                        ->get()
                );
        }

        return $this;
    }
}
