<?php

/*
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

namespace Elcodi\Component\User\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Wrapper\CartWrapper;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class AuthenticationSuccessEventListener
 */
class AuthenticationSuccessEventListener
{
    /**
     * @var CartWrapper
     *
     * Cart Wrapper holding reference to current Cart
     */
    protected $cartWrapper;

    /**
     * @var ObjectManager
     *
     * Object manager for the Cart entity
     */
    protected $cartManager;

    /**
     * Construct method
     *
     * @param CartWrapper   $cartWrapper Cart Wrapper
     * @param ObjectManager $cartManager Object Manager
     */
    public function __construct(
        CartWrapper $cartWrapper,
        ObjectManager $cartManager
    )
    {
        $this->cartWrapper = $cartWrapper;
        $this->cartManager = $cartManager;
    }

    /**
     * Assign the Cart stored in session to the logged Customer.
     *
     * When a user has succesfully logged in, a check is needed
     * to see if a Cart was created in session when she was not
     * logged.
     *
     * @param AuthenticationEvent $event Event
     */
    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        $loggedUser = $event->getAuthenticationToken()->getUser();
        $cart = $this->cartWrapper->getCartFromSession();

        if (
            ($loggedUser instanceof CustomerInterface) &&
            ($cart instanceof CartInterface && $cart->getId())
        ) {
            /*
             * We assume that a cart with an ID is
             * not a pristine entity coming from a
             * factory method. (i.e. has already been
             * flushed)
             */
            $cart->setCustomer($loggedUser);

            $this->cartManager->flush($cart);
        }
    }
}
