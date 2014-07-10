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

namespace Elcodi\UserBundle\EventListener;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\UserBundle\EventListener\Abstracts\AbstractPasswordEventListener;

/**
 * Class CustomerPasswordEventListener
 */
class CustomerPasswordEventListener extends AbstractPasswordEventListener
{
    /**
     * Check entity type
     *
     * @param AbstractEntity $entity Entity to check
     *
     * @return boolean Entity is ready for being encoded
     */
    public function checkEntityType(AbstractEntity $entity)
    {
        return ($entity instanceof CustomerInterface);
    }
}
