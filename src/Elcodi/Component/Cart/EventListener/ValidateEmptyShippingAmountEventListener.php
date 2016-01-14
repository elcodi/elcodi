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

namespace Elcodi\Component\Cart\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\Services\CartShippingAmountValidator;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class ValidateEmptyShippingAmountEventListener.
 */
final class ValidateEmptyShippingAmountEventListener
{
    /**
     * @var CartShippingAmountValidator
     *
     * Cart shipping amount validator
     */
    private $cartShippingAmountValidator;

    /**
     * Construct.
     *
     * @param CartShippingAmountValidator $cartShippingAmountValidator Cart shipping amount validator
     */
    public function __construct(CartShippingAmountValidator $cartShippingAmountValidator)
    {
        $this->cartShippingAmountValidator = $cartShippingAmountValidator;
    }

    /**
     * If the cart's shipping amount is not defined, then put an empty Money
     * value.
     *
     * @param CartOnLoadEvent $event Event
     */
    public function validateEmptyShippingAmount(CartOnLoadEvent $event)
    {
        $this
            ->cartShippingAmountValidator
            ->validateEmptyShippingAmount(
                $event->getCart()
            );
    }
}
