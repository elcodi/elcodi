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
use Elcodi\Component\Cart\Services\CartIntegrityValidator;

/**
 * Class ValidateCartIntegrityEventListener.
 */
final class ValidateCartIntegrityEventListener
{
    /**
     * @var CartIntegrityValidator
     *
     * Cart validator
     */
    private $cartIntegrityValidator;

    /**
     * Construct.
     *
     * @param CartIntegrityValidator $cartIntegrityValidator Cart validator
     */
    public function __construct(CartIntegrityValidator $cartIntegrityValidator)
    {
        $this->cartIntegrityValidator = $cartIntegrityValidator;
    }

    /**
     * Validate cart.
     *
     * @param AbstractCartEvent $event Event
     */
    public function validateCartIntegrity(AbstractCartEvent $event)
    {
        $this
            ->cartIntegrityValidator
            ->validateCartIntegrity(
                $event->getCart()
            );
    }
}
