<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since 2013
 */

namespace Elcodi\UserBundle\Repository\Interfaces;

use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;

/**
 * Class UserEmailRecoverableInterface
 */
interface UserEmaileableInterface
{
    /**
     * Find one Entity given an email
     *
     * @param string $email Email
     *
     * @return AbstractUser User found
     */
    public function findOneByEmail($email);
}
