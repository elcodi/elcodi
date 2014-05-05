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

use Doctrine\Common\Persistence\ObjectManager;
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
     * @return CustomerWrapper self Object
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Construct method
     *
     * This wrapper loads Customer from database if this exists and is authenticated.
     * Otherwise, this create new Guest without persisting it
     *
     * @param CustomerRepository       $customerRepository Customer repository
     * @param ObjectManager            $entityManager      Entity manager
     * @param SessionInterface         $session            Object of Session
     * @param CustomerFactory          $customerFactory    Customer factory
     * @param string                   $sessionFieldName   Session field name
     * @param SecurityContextInterface $securityContext    SecurityContext instance
     */
    public function __construct(
        CustomerRepository $customerRepository,
        ObjectManager $entityManager,
        SessionInterface $session,
        CustomerFactory $customerFactory,
        $sessionFieldName,
        SecurityContextInterface $securityContext = null
    )
    {
        $token = $securityContext instanceof SecurityContextInterface
            ? $securityContext->getToken()
            : null;

        if ($token instanceof UsernamePasswordToken) {

            $this->customer = $token->getUser();

        } else {

            $customerId = $session->get($sessionFieldName);

            if (null !== $customerId) {

                $this->customer = $customerRepository->findOneBy(array(
                    'id' => $customerId
                ));
            }

            /* Customer will be persisted but not flushed. */
            if (!($this->customer instanceof CustomerInterface)) {

                $this->customer = $customerFactory->create();
                $entityManager->persist($this->customer);
            }
        }
    }

}
