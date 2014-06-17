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

namespace Elcodi\UserBundle\Repository;

use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;
use Doctrine\ORM\EntityRepository;

use Elcodi\UserBundle\Repository\Interfaces\UserEmaileableInterface;

/**
 * CustomerRepository
 */
class CustomerRepository extends EntityRepository implements UserEmaileableInterface
{
    /**
     * Find one Entity given an email
     *
     * @param string $email Email
     *
     * @return AbstractUser User found
     */
    public function findOneByEmail($email)
    {
        return $this->findOneBy(array(
            'email' => $email,
        ));
    }
}
