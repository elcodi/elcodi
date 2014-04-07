<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Event fired when a customer registers
 */
class CustomerRegisterEvent extends Event
{
    /**
     * @var CustomerInterface
     *
     * Customer
     */
    protected $customer;

    /**
     * @param CustomerInterface $customer Customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return CustomerInterface User
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
