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

namespace Elcodi\UserBundle\Services;

use Elcodi\UserBundle\Entity\Address;
use Elcodi\UserBundle\Entity\Customer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Elcodi\UserBundle\ElcodiUserEvents;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\UserBundle\Event\CustomerRegisterEvent;

/**
 * Manager for Customer entities
 */
class CustomerManager
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher instance
     */
    protected $eventDispatcher;

    /**
     * @var SecurityContextInterface
     *
     * Security Context
     */
    protected $securityContext;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     * @param SecurityContextInterface $securityContext Security Context
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, SecurityContextInterface $securityContext = null)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->securityContext = $securityContext;
    }

    /**
     * Register new User into the web.
     * Creates new token given a user, with related Role set.
     *
     * @param CustomerInterface $user        User to register
     * @param string            $providerKey Provider key
     *
     * @return CustomerManager self Object
     */
    public function register(CustomerInterface $user, $providerKey)
    {
        if (!($this->securityContext instanceof SecurityContextInterface)) {
            return $this;
        }

        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->securityContext->setToken($token);

        $event = new CustomerRegisterEvent($user);
        $this->eventDispatcher->dispatch(ElcodiUserEvents::USER_REGISTER, $event);

        return $this;
    }

    /**
     * Check if customer has a valid delivery address
     *
     * @param Customer $customer
     *
     * @return bool
     */
    public function customerHasCorrectDeliveryAddress(Customer $customer)
    {
        if (($customer->getDeliveryAddress() instanceof Address)
            && ($customer->getDeliveryAddress()->getAddress())) {
            return true;
        }

        return false;
    }
}
