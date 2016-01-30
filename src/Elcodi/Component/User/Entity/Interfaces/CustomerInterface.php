<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\User\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * Interface CustomerInterface.
 *
 * Entities depending on CustomerInterfaces must implement shopping
 * capabilities and associations, such as addresses, orders, carts
 */
interface CustomerInterface extends AbstractUserInterface
{
    /**
     * Set phone.
     *
     * @param string $phone Phone
     *
     * @return $this
     */
    public function setPhone($phone);

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set identity document.
     *
     * @param string $identityDocument
     *
     * @return $this
     */
    public function setIdentityDocument($identityDocument);

    /**
     * Get identity document.
     *
     * @return string Identity document
     */
    public function getIdentityDocument();

    /**
     * Sets Guest.
     *
     * @param bool $guest Guest
     *
     * @return $this Self object
     */
    public function setGuest($guest);

    /**
     * Get Guest.
     *
     * @return bool Guest
     */
    public function isGuest();

    /**
     * Sets Newsletter.
     *
     * @param bool $newsletter Newsletter
     *
     * @return $this Self object
     */
    public function setNewsletter($newsletter);

    /**
     * Get Newsletter.
     *
     * @return bool Newsletter
     */
    public function getNewsletter();

    /**
     * Add Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function addOrder(OrderInterface $order);

    /**
     * Remove Order.
     *
     * @param OrderInterface $order
     *
     * @return $this Self object
     */
    public function removeOrder(OrderInterface $order);

    /**
     * Set orders.
     *
     * @param Collection $orders Orders
     *
     * @return $this Self object
     */
    public function setOrders(Collection $orders);

    /**
     * Get user orders.
     *
     * @return Collection Customerinterface orders
     */
    public function getOrders();

    /**
     * Add Cart.
     *
     * @param CartInterface $cart
     *
     * @return $this Self object
     */
    public function addCart(CartInterface $cart);

    /**
     * Remove Cart.
     *
     * @param CartInterface $cart
     *
     * @return $this Self object
     */
    public function removeCart(CartInterface $cart);

    /**
     * @param Collection $carts
     *
     * @return $this Self object
     */
    public function setCarts(Collection $carts);

    /**
     * Get Cart collection.
     *
     * @return Collection
     */
    public function getCarts();

    /**
     * Add address.
     *
     * @param AddressInterface $address
     *
     * @return $this Self object
     */
    public function addAddress(AddressInterface $address);

    /**
     * Remove address.
     *
     * @param AddressInterface $address
     *
     * @return $this Self object
     */
    public function removeAddress(AddressInterface $address);

    /**
     * Set addresses.
     *
     * @param Collection $addresses Addresses
     *
     * @return $this Self object
     */
    public function setAddresses(Collection $addresses);

    /**
     * Get addresses.
     *
     * @return Collection Addresses
     */
    public function getAddresses();

    /**
     * Set Delivery Address.
     *
     * @param AddressInterface $deliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress = null);

    /**
     * Get Delivery address.
     *
     * @return AddressInterface
     */
    public function getDeliveryAddress();

    /**
     * Set Invoice Address.
     *
     * @param AddressInterface $invoiceAddress
     *
     * @return $this Self object
     */
    public function setInvoiceAddress(AddressInterface $invoiceAddress = null);

    /**
     * Get Invoice address.
     *
     * @return AddressInterface
     */
    public function getInvoiceAddress();

    /**
     * Set language.
     *
     * @param LanguageInterface $language The language
     *
     * @return $this Self object
     */
    public function setLanguage(LanguageInterface $language);

    /**
     * Get language.
     *
     * @return LanguageInterface
     */
    public function getLanguage();
}
