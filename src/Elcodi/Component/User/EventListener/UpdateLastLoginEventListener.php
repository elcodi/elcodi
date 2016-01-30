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

namespace Elcodi\Component\User\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Core\Services\ManagerProvider;
use Elcodi\Component\User\Entity\Interfaces\LastLoginInterface;

/**
 * Class UpdateLastLoginEventListener.
 */
class UpdateLastLoginEventListener
{
    /**
     * @var ManagerProvider
     *
     * Object Manager provider
     */
    private $objectManagerProvider;

    /**
     * @var DateTimeFactory
     *
     * DateTime factory
     */
    private $dateTimeFactory;

    /**
     * Construct.
     *
     * @param ManagerProvider $objectManagerProvider Object manager provider
     * @param DateTimeFactory $dateTimeFactory       DateTime factory
     */
    public function __construct(
        ManagerProvider $objectManagerProvider,
        DateTimeFactory $dateTimeFactory
    ) {
        $this->objectManagerProvider = $objectManagerProvider;
        $this->dateTimeFactory = $dateTimeFactory;
    }

    /**
     * Update last login date.
     *
     * @param InteractiveLoginEvent $event Interactive login event
     *
     * @return $this Self object
     */
    public function updateLastLogin(InteractiveLoginEvent $event)
    {
        $user = $event
            ->getAuthenticationToken()
            ->getUser();

        if ($user instanceof LastLoginInterface) {
            $now = $this
                ->dateTimeFactory
                ->create();

            $user->setLastLoginAt($now);

            $this
                ->objectManagerProvider
                ->getManagerByEntityNamespace(get_class($user))
                ->flush($user);
        }

        return $this;
    }
}
