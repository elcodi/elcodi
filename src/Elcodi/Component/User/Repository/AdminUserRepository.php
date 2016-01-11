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

namespace Elcodi\Component\User\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Repository\Interfaces\UserEmaileableInterface;

/**
 * Class AdminUserRepository.
 */
class AdminUserRepository extends EntityRepository implements UserEmaileableInterface
{
    /**
     * Find one Entity given an email.
     *
     * @param string $email Email
     *
     * @return AbstractUserInterface|null User found
     */
    public function findOneByEmail($email)
    {
        $user = $this
            ->findOneBy([
                'email' => $email,
            ]);

        return ($user instanceof AbstractUserInterface)
            ? $user
            : null;
    }
}
