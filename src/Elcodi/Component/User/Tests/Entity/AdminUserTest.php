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

namespace Elcodi\Component\User\Tests\Entity;

use Elcodi\Component\User\Entity\AdminUser;

class AdminUserTest extends Abstracts\AbstractUserTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new AdminUser();
    }

    public function testGetRoles()
    {
        parent::testGetRoles();

        $roles = $this->object->getRoles();

        $contained = false;
        foreach ($roles as $role) {
            $contained = $contained || ('ROLE_ADMIN' === $role->getRole());
        }

        $this->assertTrue($contained, 'No ROLE_ADMIN defined.');
    }
}
