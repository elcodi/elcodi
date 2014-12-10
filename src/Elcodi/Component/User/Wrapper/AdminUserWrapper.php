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

namespace Elcodi\Component\User\Wrapper;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\User\Factory\AdminUserFactory;

/**
 * Cart to order service
 */
class AdminUserWrapper
{
    /**
     * @var AdminUserInterface
     *
     * AdminUser
     */
    protected $adminUser;

    /**
     * @var AdminUserFactory
     *
     * Admin User factory
     */
    protected $adminUserFactory;

    /**
     * @var TokenStorageInterface
     *
     * Token storage
     */
    protected $tokenStorage;

    /**
     * Construct method
     *
     * This wrapper loads AdminUser from database if this exists and is
     * authenticated.
     *
     * Otherwise, this create new Guest without persisting it
     *
     * @param AdminUserFactory      $adminUserFactory Customer factory
     * @param TokenStorageInterface $tokenStorage TokenStorageInterface instance
     */
    public function __construct(
        AdminUserFactory $adminUserFactory,
        TokenStorageInterface $tokenStorage = null
    )
    {
        $this->adminUserFactory = $adminUserFactory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Return current loaded customer
     *
     * @return AdminUserInterface current customer
     */
    public function getAdminUser()
    {
        return $this->adminUser;
    }

    /**
     * Set admin user
     *
     * @param AdminUserInterface $adminUser Admin User
     *
     * @return $this self Object
     */
    public function setAdminUser(AdminUserInterface $adminUser = null)
    {
        $this->adminUser = $adminUser;

        return $this;
    }

    /**
     * Load admin user method
     *
     * This method tries to load AdminUser stored in Session, using specific
     * session field name.
     *
     * If this AdminUser is found, stores it locally and uses it as "official"
     * adminUser object
     *
     * Otherwise, new AdminUser is created and stored (not flushed nor
     * persisted)
     *
     * @return AdminUserInterface Loaded admin user
     */
    public function loadAdminUser()
    {
        if ($this->adminUser instanceof AdminUserInterface) {
            return $this->adminUser;
        }

        $token = $this->tokenStorage instanceof TokenStorageInterface
            ? $this->tokenStorage->getToken()
            : null;

        if ($token instanceof UsernamePasswordToken) {

            $this->adminUser = $token->getUser();

        } else {

            $this->adminUser = $this->adminUserFactory->create();
        }

        return $this->adminUser;
    }

    /**
     * Reload AdminUser.
     *
     * This method assumes that current adminUser is not valid anymore, and
     * tries to reload it.
     *
     * @return AdminUserInterface Loaded customer
     */
    public function reloadAdminUser()
    {
        return $this
            ->setAdminUser(null)
            ->loadAdminUser();
    }
}
