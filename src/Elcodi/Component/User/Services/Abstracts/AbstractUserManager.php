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

namespace Elcodi\Component\User\Services\Abstracts;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
     * @var TokenStorageInterface
     *
     * Token storage
     */
    protected $tokenStorage;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     * @param TokenStorageInterface    $securityContext Token storage
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $securityContext = null
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $securityContext;
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
        if (!($this->tokenStorage instanceof TokenStorageInterface)) {
            return $this;
        }

        $token = new UsernamePasswordToken(
            $user,
            null,
            $providerKey,
            $user->getRoles()
        );

        $this->tokenStorage->setToken($token);

        $event = new UserRegisterEvent($user);
        $this->eventDispatcher->dispatch(
            ElcodiUserEvents::ABSTRACTUSER_REGISTER,
            $event
        );

        return $this;
    }
}
