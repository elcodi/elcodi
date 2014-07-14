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

namespace Elcodi\UserBundle\Event;

use Elcodi\UserBundle\Entity\Interfaces\AbstractUserInterface;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractUserRegisterEvent
 */
class AbstractUserRegisterEvent extends Event
{
    /**
     * @var AbstractUserInterface
     *
     * User
     */
    protected $User;

    /**
     * Construct method
     *
     * @param AbstractUserInterface $User User
     */
    public function __construct(AbstractUserInterface $User)
    {
        $this->User = $User;
    }

    /**
     * @return AbstractUserInterface User
     */
    public function getUser()
    {
        return $this->User;
    }
}
