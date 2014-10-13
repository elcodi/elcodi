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

namespace Elcodi\Component\User\Services\Abstracts;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Elcodi\Component\User\ElcodiUserEvents;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Event\UserRegisterEvent;

/**
 * Class AbstractUserManager
 */
abstract class AbstractUserManager
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
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $securityContext = null
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->securityContext = $securityContext;
    }

    /**
     * Register new User into the web.
     * Creates new token given a user, with related Role set.
     *
     * @param AbstractUserInterface $user        User to register
     * @param string                $providerKey Provider key
     *
     * @return $this self Object
     */
    public function register(AbstractUserInterface $user, $providerKey)
    {
        if (!($this->securityContext instanceof SecurityContextInterface)) {
            return $this;
        }

        $token = new UsernamePasswordToken(
            $user,
            null,
            $providerKey,
            $user->getRoles()
        );

        $this->securityContext->setToken($token);

        $event = new UserRegisterEvent($user);
        $this->eventDispatcher->dispatch(
            ElcodiUserEvents::ABSTRACTUSER_REGISTER,
            $event
        );

        return $this;
    }
}
