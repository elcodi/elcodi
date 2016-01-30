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

namespace Elcodi\Component\User\Services;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Services\Abstracts\AbstractUserManager;

/**
 * Manager for Customer entities.
 */
class CustomerManager extends AbstractUserManager
{
    /**
     * Register new User into the web.
     * Creates new token given a user, with related Role set.
     *
     * @param AbstractUserInterface $user User to register
     *
     * @return $this Self object
     */
    public function register(AbstractUserInterface $user)
    {
        parent::register($user);

        /**
         * @var CustomerInterface $user
         */
        $this
            ->userEventDispatcher
            ->dispatchOnCustomerRegisteredEvent($user);

        return $this;
    }
}
