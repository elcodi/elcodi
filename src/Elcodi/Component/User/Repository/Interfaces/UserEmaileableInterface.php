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

namespace Elcodi\Component\User\Repository\Interfaces;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Interface UserEmailRecoverableInterface
 */
interface UserEmaileableInterface
{
    /**
     * Find one Entity given an email
     *
     * @param string $email Email
     *
     * @return AbstractUserInterface|null User found
     */
    public function findOneByEmail($email);
}
