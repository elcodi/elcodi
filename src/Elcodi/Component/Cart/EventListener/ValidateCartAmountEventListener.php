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

use Elcodi\Component\Cart\Event\Abstracts\AbstractCartEvent;
use Elcodi\Component\Cart\Services\CartAmountValidator;

/**
 * Class ValidateCartAmountEventListener.
 *
 * @author Berny Cantos <be@rny.cc>
 */
final class ValidateCartAmountEventListener
{
    /**
     * @var CartAmountValidator
     *
     * Cart amount validator
     */
    private $cartAmountValidator;

    /**
     * Construct.
     *
     * @param CartAmountValidator $cartAmountValidator Cart amount validator
     */
    public function __construct(CartAmountValidator $cartAmountValidator)
    {
        $this->cartAmountValidator = $cartAmountValidator;
    }

    /**
     * Validate cart amount.
     *
     * @param AbstractCartEvent $event Event
     */
    public function validateAmount(AbstractCartEvent $event)
    {
        $this
            ->cartAmountValidator
            ->validateAmount(
                $event->getCart()
            );
    }
}
