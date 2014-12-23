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

namespace Elcodi\Component\User\Factory;

use DateTime;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;

/**
 * Class AdminUserFactory
 */
class AdminUserFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return AdminUserInterface Empty entity
     */
    public function create()
    {
        /**
         * @var AdminUserInterface $adminUser
         */
        $classNamespace = $this->getEntityNamespace();
        $adminUser = new $classNamespace();
        $adminUser
            ->setGender(ElcodiUserProperties::GENDER_UNKNOWN)
            ->setEnabled(true)
            ->setCreatedAt(new DateTime());

        return $adminUser;
    }
}
