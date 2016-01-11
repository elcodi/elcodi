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

namespace Elcodi\Component\User\Wrapper;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\User\Factory\AdminUserFactory;

/**
 * Cart to order service.
 */
class AdminUserWrapper implements WrapperInterface
{
    /**
     * @var AdminUserInterface|object|string
     *
     * AdminUser element. This parameter can be filled with an internal
     * AdminUser implementation, with an object with __toString() method
     * implemented or with a string.
     *
     * See \Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     * for more information about it
     */
    private $adminUser;

    /**
     * @var AdminUserFactory
     *
     * Admin User factory
     */
    private $adminUserFactory;

    /**
     * @var TokenStorageInterface
     *
     * Token storage
     */
    private $tokenStorage;

    /**
     * Construct method.
     *
     * This wrapper loads AdminUser from database if this exists and is
     * authenticated.
     *
     * Otherwise, this create new Guest without persisting it
     *
     * @param AdminUserFactory           $adminUserFactory Customer factory
     * @param TokenStorageInterface|null $tokenStorage     TokenStorageInterface instance
     */
    public function __construct(
        AdminUserFactory $adminUserFactory,
        TokenStorageInterface $tokenStorage = null
    ) {
        $this->adminUserFactory = $adminUserFactory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        if ($this->adminUser instanceof AdminUserInterface) {
            return $this->adminUser;
        }

        $token = $this->tokenStorage instanceof TokenStorageInterface
            ? $this->tokenStorage->getToken()
            : null;

        $this->adminUser = ($token instanceof UsernamePasswordToken)
            ? $token->getUser()
            : $this
                ->adminUserFactory
                ->create();

        return $this->adminUser;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        $this->adminUser = null;

        return $this;
    }
}
