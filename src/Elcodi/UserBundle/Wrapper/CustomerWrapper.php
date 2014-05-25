<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\UserBundle\Wrapper;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @var SessionInterface
     *
     * Session
     */
    protected $session;

    /**
     * @var CustomerFactory
     *
     * Customer factory
     */
    protected $customerFactory;

    /**
     * @var string
     *
     * Session field name
     */
    protected $sessionFieldName;

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
     * @param SessionInterface         $session            Object of Session
     * @param CustomerFactory          $customerFactory    Customer factory
     * @param string                   $sessionFieldName   Session field name
     * @param SecurityContextInterface $securityContext    SecurityContext instance
     */
    public function __construct(
        CustomerRepository $customerRepository,
        SessionInterface $session,
        CustomerFactory $customerFactory,
        $sessionFieldName,
        SecurityContextInterface $securityContext = null
    )
    {
        $this->customerRepository = $customerRepository;
        $this->session = $session;
        $this->customerFactory = $customerFactory;
        $this->sessionFieldName = $sessionFieldName;
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

            $customerId = $this->session->get($this->sessionFieldName);

            if (null !== $customerId) {

                $this->customer = $this->customerRepository->findOneBy(array(
                    'id' => $customerId
                ));
            }

            /**
             * Customer not found. Generating new one
             */
            if (!($this->customer instanceof CustomerInterface)) {

                $this->customer = $this->customerFactory->create();
            }
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
