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

namespace Elcodi\Component\User\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * Entities depending on CustomerInterfaces must implement shopping
 * capabilities and associations, such as addresses, orders, carts
 */
interface CustomerInterface extends AbstractUserInterface
{
    /**
     * @param string
     *
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function addOrder(OrderInterface $order);

    /**
     * Remove Order
     *
     * @param OrderInterface $order
     *
     * @return self
     */
    public function removeOrder(OrderInterface $order);

    /**
     * Set orders
     *
     * @param Collection $orders Orders
     *
     * @return self
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
     * @return self
     */
    public function addCart(CartInterface $cart);

    /**
     * Remove Cart
     *
     * @param CartInterface $cart
     *
     * @return self
     */
    public function removeCart(CartInterface $cart);

    /**
     * @param Collection $carts
     *
     * @return self
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
     * @return self
     */
    public function addAddress(AddressInterface $address);

    /**
     * Remove address
     *
     * @param AddressInterface $address
     *
     * @return self
     */
    public function removeAddress(AddressInterface $address);

    /**
     * Set addresses
     *
     * @param Collection $addresses Addresses
     *
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setLanguage(LanguageInterface $language);

    /**
     * Get language
     *
     * @return LanguageInterface
     */
    public function getLanguage();
}
