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

namespace Elcodi\UserBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;

/**
 * Entities depending on CustomerInterfaces must implement shopping
 * capabilities and associations, such as addresses, orders, carts
 */
interface CustomerInterface extends AbstractUserInterface
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
}
