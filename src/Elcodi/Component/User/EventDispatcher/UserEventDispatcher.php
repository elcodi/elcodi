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

namespace Elcodi\Component\User\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\User\ElcodiUserEvents;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Event\AdminUserRegisterEvent;
use Elcodi\Component\User\Event\CustomerRegisterEvent;
use Elcodi\Component\User\Event\UserRegisterEvent;
use Elcodi\Component\User\EventDispatcher\Interfaces\UserEventDispatcherInterface;

/**
 * Class UserEventDispatcher.
 */
class UserEventDispatcher extends AbstractEventDispatcher implements UserEventDispatcherInterface
{
    /**
     * Dispatch user created event.
     *
     * @param AbstractUserInterface $user User registered
     *
     * @return $this Self object
     */
    public function dispatchOnUserRegisteredEvent(AbstractUserInterface $user)
    {
        $event = new UserRegisterEvent($user);
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiUserEvents::ABSTRACTUSER_REGISTER,
                $event
            );

        return $this;
    }

    /**
     * Dispatch customer created event.
     *
     * @param CustomerInterface $customer Customer registered
     *
     * @return $this Self object
     */
    public function dispatchOnCustomerRegisteredEvent(CustomerInterface $customer)
    {
        $event = new CustomerRegisterEvent($customer);
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiUserEvents::CUSTOMER_REGISTER,
                $event
            );

        return $this;
    }

    /**
     * Dispatch admin user created event.
     *
     * @param AdminUserInterface $adminUser AdminUser registered
     *
     * @return $this Self object
     */
    public function dispatchOnAdminUserRegisteredEvent(AdminUserInterface $adminUser)
    {
        $event = new AdminUserRegisterEvent($adminUser);
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiUserEvents::ADMINUSER_REGISTER,
                $event
            );

        return $this;
    }
}
