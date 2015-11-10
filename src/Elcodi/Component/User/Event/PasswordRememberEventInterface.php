<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\User\Event;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Event fired when a customer unsubscribes from newsletter
 *
 * This event send an email to customer
 */
interface PasswordRememberEventInterface
{
    /**
     * Get user
     *
     * @return AbstractUserInterface User
     */
    public function getUser();

    /**
     * Get remember url
     *
     * @return string Remember url
     */
    public function getRememberUrl();
}
