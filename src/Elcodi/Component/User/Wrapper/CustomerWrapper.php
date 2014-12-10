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
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Factory\CustomerFactory;

/**
 * Cart to order service
 */
class CustomerWrapper
{
    /**
     * @var CustomerInterface
     *
     * Customer
     */
    protected $customer;

    /**
     * @var CustomerFactory
     *
     * Customer factory
     */
    protected $customerFactory;

    /**
     * @var TokenStorageInterface
     *
     * Token storage
     */
    protected $tokenStorage;

    /**
     * Construct method
     *
     * This wrapper loads Customer from database if this exists and is authenticated.
     * Otherwise, this create new Guest without persisting it
     *
     * @param CustomerFactory       $customerFactory Customer factory
     * @param TokenStorageInterface $tokenStorage TokenStorageInterface instance
     */
    public function __construct(
        CustomerFactory $customerFactory,
        TokenStorageInterface $tokenStorage = null
    )
    {
        $this->customerFactory = $customerFactory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Return current loaded customer
     *
     * @return CustomerInterface current customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return $this self Object
     */
    public function setCustomer(CustomerInterface $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Load customer method
     *
     * This method tries to load Customer stored in Session, using specific
     * session field name.
     *
     * If this customer is found, stores it locally and uses it as "official"
     * customer object
     *
     * Otherwise, new Customer is created and stored (not flushed nor persisted)
     *
     * @return CustomerInterface Loaded customer
     */
    public function loadCustomer()
    {
        if ($this->customer instanceof CustomerInterface) {
            return $this->customer;
        }

        $customer = $this->getCustomerFromToken();

        if (null === $customer) {
            $customer = $this->customerFactory->create();
        }

        $this->customer = $customer;

        return $customer;
    }

    /**
     * Reload Customer.
     *
     * This method assumes that current customer is not valid anymore, and tries
     * to reload it.
     *
     * @return CustomerInterface Loaded customer
     */
    public function reloadCustomer()
    {
        return $this
            ->setCustomer(null)
            ->loadCustomer();
    }

    /**
     * Return the current user from security context.
     *
     * @return CustomerInterface Current customer in token
     */
    protected function getCustomerFromToken()
    {
        if (!($this->tokenStorage instanceof TokenStorageInterface)) {
            return null;
        }

        $token = $this->tokenStorage->getToken();
        if (!($token instanceof TokenInterface)) {
            return null;
        }

        $customer = $token->getUser();
        if (!($customer instanceof CustomerInterface)) {
            return null;
        }

        return $customer;
    }
}
