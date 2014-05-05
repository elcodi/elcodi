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

namespace Elcodi\UserBundle\Entity\Interfaces;

use DateTime;
use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;

/**
 * Entities depending on CustomerInterfaces must implement shopping
 * capabilities and associations, such as addresses, orders, carts
 */
interface CustomerInterface
{
    /**
     * User roles
     *
     * @return array Roles
     */
    public function getRoles();

    /**
     * @param string
     *
     * @return $this
     */
    public function setPhone($phone);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set identity document
     *
     * @param string $identityDocument
     *
     * @return $this
     */
    public function setIdentityDocument($identityDocument);

    /**
     * Get identity document
     *
     * @return string Identity document
     */
    public function getIdentityDocument();

    /**
     * Sets Guest
     *
     * @param boolean $guest Guest
     *
     * @return Customerinterface Self object
     */
    public function setGuest($guest);

    /**
     * Get Guest
     *
     * @return boolean Guest
     */
    public function isGuest();

    /**
     * Sets Newsletter
     *
     * @param boolean $newsletter Newsletter
     *
     * @return Customerinterface Self object
     */
    public function setNewsletter($newsletter);

    /**
     * Get Newsletter
     *
     * @return boolean Newsletter
     */
    public function getNewsletter();

    /**
     * Add Order
     *
     * @param OrderInterface $order Order
     *
     * @return Customerinterface self Object
     */
    public function addOrder(OrderInterface $order);

    /**
     * Remove Order
     *
     * @param OrderInterface $order
     *
     * @return Customerinterface self Object
     */
    public function removeOrder(OrderInterface $order);

    /**
     * Set orders
     *
     * @param Collection $orders Orders
     *
     * @return Customerinterface self Object
     */
    public function setOrders($orders);

    /**
     * Get user orders
     *
     * @return Collection Customerinterface orders
     */
    public function getOrders();

    /**
     * Add Cart
     *
     * @param CartInterface $cart
     *
     * @return Customerinterface self Object
     */
    public function addCart(CartInterface $cart);

    /**
     * Remove Cart
     *
     * @param CartInterface $cart
     *
     * @return Customerinterface self Object
     */
    public function removeCart(CartInterface $cart);

    /**
     * @param Collection $carts
     *
     * @return Customerinterface self Object
     */
    public function setCarts($carts);

    /**
     * Get Cart collection
     *
     * @return Collection
     */
    public function getCarts();

    /**
     * Add address
     *
     * @param AddressInterface $address
     *
     * @return Customerinterface self Object
     */
    public function addAddress(AddressInterface $address);

    /**
     * Remove address
     *
     * @param AddressInterface $address
     *
     * @return Customerinterface self Object
     */
    public function removeAddress(AddressInterface $address);

    /**
     * Set addresses
     *
     * @param Collection $addresses Addresses
     *
     * @return Customerinterface self Object
     */
    public function setAddresses(Collection $addresses);

    /**
     * Get addresses
     *
     * @return Collection Addresses
     */
    public function getAddresses();

    /**
     * Set Delivery Address
     *
     * @param AddressInterface $deliveryAddress
     *
     * @return Customerinterface self Object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress = null);

    /**
     * Get Delivery address
     *
     * @return AddressInterface
     */
    public function getDeliveryAddress();

    /**
     * Set Invoice Address
     *
     * @param AddressInterface $invoiceAddress
     *
     * @return Customerinterface self Object
     */
    public function setInvoiceAddress(AddressInterface $invoiceAddress = null);

    /**
     * Get Invoice address
     *
     * @return AddressInterface
     */
    public function getInvoiceAddress();

    /**
     * Set language
     *
     * @param LanguageInterface $language The language
     *
     * @return Customerinterface self Object
     */
    public function setLanguage(LanguageInterface $language);

    /**
     * Get language
     *
     * @return LanguageInterface
     */
    public function getLanguage();

    /**
     * Set recovery hash
     *
     * @param string $recoveryHash
     *
     * @return Customerinterface self Object
     */
    public function setRecoveryHash($recoveryHash);

    /**
     * Get recovery hash
     *
     * @return string Recovery Hash
     */
    public function getRecoveryHash();

    /**
     * Sets Firstname
     *
     * @param string $firstname Firstname
     *
     * @return Customerinterface Self object
     */
    public function setFirstname($firstname);

    /**
     * Get Firstname
     *
     * @return string Firstname
     */
    public function getFirstname();

    /**
     * Sets Lastname
     *
     * @param string $lastname Lastname
     *
     * @return Customerinterface Self object
     */
    public function setLastname($lastname);

    /**
     * Get Lastname
     *
     * @return string Lastname
     */
    public function getLastname();

    /**
     * Set gender
     *
     * @param int $gender Gender
     *
     * @return Customerinterface self Object
     */
    public function setGender($gender);

    /**
     * Get gender
     *
     * @return int Gender
     */
    public function getGender();

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customerinterface self Object
     */
    public function setEmail($email);

    /**
     * Return email
     *
     * @return string Email
     */
    public function getEmail();

    /**
     * Set username
     *
     * @param string $username Username
     *
     * @return Customerinterface self Object
     */
    public function setUsername($username);

    /**
     * Get username
     *
     * @return String Username
     */
    public function getUsername();

    /**
     * Get birthday
     *
     * @return DateTime
     */
    public function getBirthday();

    /**
     * Set birthday
     *
     * @param DateTime $birthday
     *
     * @return Customerinterface self Object
     */
    public function setBirthday(DateTime $birthday = null);

    /**
     * Get user full name
     *
     * @return string Full name
     */
    public function getFullName();

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customerinterface self Object
     */
    public function setPassword($password);

    /**
     * Get password
     *
     * @return string Password
     */
    public function getPassword();
}
