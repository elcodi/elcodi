<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\User\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

use Elcodi\Component\User\Event\UserRegisterEvent;

/**
 * Class AutologinOnRegisterEventListener
 */
class AutologinOnRegisterEventListener
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    private $requestStack;

    /**
     * @var TokenStorageInterface
     *
     * Token storage
     */
    protected $tokenStorage;

    /**
     * @var EventDispatcherInterface
     *
     * Event dispatcher
     */
    protected $dispatcher;

    /**
     * @var string
     *
     * Provider key
     */
    protected $providerKey;

    /**
     * Constructor
     *
     * @param RequestStack             $requestStack Request stack
     * @param TokenStorageInterface    $tokenStorage Token storage
     * @param EventDispatcherInterface $dispatcher   Event dispatcher
     * @param string                   $providerKey  Provider key
     */
    public function __construct(
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $dispatcher,
        $providerKey
    ) {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->providerKey = $providerKey;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Autologin users after registration
     *
     * @param UserRegisterEvent $event User registered event
     */
    public function onUserRegister(UserRegisterEvent $event)
    {
        if (null === $this->tokenStorage->getToken()) {
            return;
        }

        $user = $event->getUser();

        $token = new UsernamePasswordToken(
            $user,
            null,
            $this->providerKey,
            $user->getRoles()
        );

        $this
            ->tokenStorage
            ->setToken($token);

        $event = new InteractiveLoginEvent(
            $this->requestStack->getMasterRequest(),
            $token
        );

        $this
            ->dispatcher
            ->dispatch(
                SecurityEvents::INTERACTIVE_LOGIN,
                $event
            );
    }
}
