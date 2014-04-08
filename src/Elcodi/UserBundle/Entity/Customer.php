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

namespace Elcodi\UserBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\UserBundle\Entity\Interfaces\AddressInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;

/**
 * A Customer is a User with shopping capabilities and associations,
 * such as addresses, orders, carts
 */
class Customer extends AbstractUser implements CustomerInterface
{
    /**
     * @var Collection
     *
     * Addresses
     */
    protected $addresses;

    /**
     * @var LanguageInterface
     *
     * Language
     */
    protected $language;

    /**
     * @var string
     *
     * Phone
     */
    protected $phone;

    /**
     * @var string
     *
     * Identity document
     */
    protected $identityDocument;

    /**
     * @var boolean
     *
     * Is guest
     */
    protected $guest;

    /**
     * @var bool
     *
     * Has newsletter
     */
    protected $newsletter;

    /**
     * @var Collection
     *
     * Carts
     */
    protected $carts;

    /**
     * @var Collection
     *
     * Orders
     */
    protected $orders;

    /**
     * @var AddressInterface
     *
     * Delivery address
     */
    protected $deliveryAddress;

    /**
     * @var AddressInterface
     *
     * Invoice address
     */
    protected $invoiceAddress;

    /**
     * User roles
     *
     * @return array Roles
     */
    public function getRoles()
    {
        return array('ROLE_CUSTOMER');
    }

    /**
     * @param string
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set identity doument
     *
     * @param string $identityDocument
     *
     * @return $this
     */
    public function setIdentityDocument($identityDocument)
    {
        $this->identityDocument = $identityDocument;

        return $this;
    }

    /**
     * Get identity document
     *
     * @return string Identity document
     */
    public function getIdentityDocument()
    {
        return $this->identityDocument;
    }

    /**
     * Sets Guest
     *
     * @param boolean $guest Guest
     *
     * @return Customer Self object
     */
    public function setGuest($guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get Guest
     *
     * @return boolean Guest
     */
    public function isGuest()
    {
        return $this->guest;
    }

    /**
     * Sets Newsletter
     *
     * @param boolean $newsletter Newsletter
     *
     * @return Customer Self object
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get Newsletter
     *
     * @return boolean Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Add Order
     *
     * @param OrderInterface $order Order
     *
     * @return Customer self Object
     */
    public function addOrder(OrderInterface $order)
    {
        $this->orders->add($order);

        return $this;
    }

    /**
     * Remove Order
     *
     * @param OrderInterface $order
     *
     * @return Customer self Object
     */
    public function removeOrder(OrderInterface $order)
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * Set orders
     *
     * @param Collection $orders Orders
     *
     * @return Customer self Object
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get user orders
     *
     * @return Collection Customer orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add Cart
     *
     * @param CartInterface $cart
     *
     * @return Customer self Object
     */
    public function addCart(CartInterface $cart)
    {
        $this->carts->add($cart);

        return $this;
    }

    /**
     * Remove Cart
     *
     * @param CartInterface $cart
     *
     * @return Customer self Object
     */
    public function removeCart(CartInterface $cart)
    {
        $this->carts->removeElement($cart);

        return $this;
    }

    /**
     * @param Collection $carts
     *
     * @return Customer self Object
     */
    public function setCarts($carts)
    {
        $this->carts = $carts;

        return $this;
    }

    /**
     * Get Cart collection
     *
     * @return Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * Add address
     *
     * @param AddressInterface $address
     *
     * @return Customer self Object
     */
    public function addAddress(AddressInterface $address)
    {
        $this->addresses->add($address);

        return $this;
    }

    /**
     * Remove address
     *
     * @param AddressInterface $address
     *
     * @return Customer self Object
     */
    public function removeAddress(AddressInterface $address)
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    /**
     * Set addresses
     *
     * @param Collection $addresses Addresses
     *
     * @return Customer self Object
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * Get addresses
     *
     * @return Collection Addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Set Delivery Address
     *
     * @param AddressInterface $deliveryAddress
     *
     * @return Customer self Object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress = null)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get Delivery address
     *
     * @return AddressInterface
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set Invoice Address
     *
     * @param AddressInterface $invoiceAddress
     *
     * @return Customer self Object
     */
    public function setInvoiceAddress(AddressInterface $invoiceAddress = null)
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get Invoice address
     *
     * @return AddressInterface
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Set language
     *
     * @param LanguageInterface $language The language
     *
     * @return Customer self Object
     */
    public function setLanguage(LanguageInterface $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return LanguageInterface
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sleep implementation for some reason
     *
     * @url http://asiermarques.com/2013/symfony2-security-usernamepasswordtokenserialize-must-return-a-string-or-null/
     *
     * @todo Find out what reason
     */
    public function __sleep()
    {
        return array('id', 'username', 'email');
    }

}
