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

use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\User\EventListener\Abstracts\AbstractPasswordEventListener;

/**
 * Class AdminUserPasswordEventListener.
 */
class AdminUserPasswordEventListener extends AbstractPasswordEventListener
{
    /**
     * Check entity type.
     *
     * @param object $entity Entity to check
     *
     * @return bool Entity is ready for being encoded
     */
    public function checkEntityType($entity)
    {
        return $entity instanceof AdminUserInterface;
    }
}
