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

namespace Elcodi\UserBundle\Wrapper;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Elcodi\UserBundle\Factory\CustomerFactory;
use Elcodi\UserBundle\Repository\CustomerRepository;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

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
     * @var CustomerRepository
     *
     * Customer repository
     */
    protected $customerRepository;

    /**
     * @var CustomerFactory
     *
     * Customer factory
     */
    protected $customerFactory;

    /**
     * @var SecurityContextInterface
     *
     * Security context
     */
    protected $securityContext;

    /**
     * Construct method
     *
     * This wrapper loads Customer from database if this exists and is authenticated.
     * Otherwise, this create new Guest without persisting it
     *
     * @param CustomerRepository       $customerRepository Customer repository
     * @param CustomerFactory          $customerFactory    Customer factory
     * @param SecurityContextInterface $securityContext    SecurityContext instance
     */
    public function __construct(
        CustomerRepository $customerRepository,
        CustomerFactory $customerFactory,
        SecurityContextInterface $securityContext = null
    )
    {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->securityContext = $securityContext;
    }

    /**
     * Return current loaded customer
     *
     * @return CustomerInterface current customer
     *
     * @api
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
     * @return CustomerWrapper self Object
     *
     * @api
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
     *
     * @api
     */
    public function loadCustomer()
    {
        if ($this->customer instanceof CustomerInterface) {
            return $this->customer;
        }

        $token = $this->securityContext instanceof SecurityContextInterface
            ? $this->securityContext->getToken()
            : null;

        if ($token instanceof UsernamePasswordToken) {

            $this->customer = $token->getUser();

        } else {

            $this->customer = $this->customerFactory->create();
        }

        return $this->customer;
    }

    /**
     * Reload Customer.
     *
     * This method assumes that current customer is not valid anymore, and tries
     * to reload it.
     *
     * @return CustomerInterface Loaded customer
     *
     * @api
     */
    public function reloadCustomer()
    {
        return $this
            ->setCustomer(null)
            ->loadCustomer();
    }
}
