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

namespace Elcodi\UserBundle\Entity;

use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;
use Elcodi\UserBundle\Entity\Interfaces\AdminUserInterface;

/**
 * Class AdminUser
 */
class AdminUser extends AbstractUser implements AdminUserInterface
{
    /**
     * User roles
     *
     * @return array Roles
     */
    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }
}
