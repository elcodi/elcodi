<?php

namespace Elcodi\UserBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\CartBundle\Wrapper\CartWrapper;
use JMS\DiExtraBundle\Annotation\AfterSetup;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

/**
 * Class AuthenticationSuccessEventListener
 *
 * @package Elcodi\UserBundle\EventListener
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
     * @param CartWrapper $cartWrapper
     * @param ObjectManager $cartManager
     */
    public function __construct(
        CartWrapper $cartWrapper,
        ObjectManager $cartManager)
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
     * @param AuthenticationEvent $event
     */
    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        $loggedUser = $event->getAuthenticationToken()->getUser();
        $cart = $this->cartWrapper->getCartFromSession();

        if ($cart->getId()) {
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