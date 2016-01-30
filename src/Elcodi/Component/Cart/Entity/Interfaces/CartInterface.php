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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Interface CartInterface.
 */
interface CartInterface
    extends
        DateTimeInterface,
        DimensionableInterface,
        IdentifiableInterface
{
    /**
     * Get Loaded.
     *
     * @return bool Loaded
     */
    public function isLoaded();

    /**
     * Sets Loaded.
     *
     * @param bool $loaded Loaded
     *
     * @return $this Self object
     */
    public function setLoaded($loaded);

    /**
     * Gets amount with tax.
     *
     * @return MoneyInterface price with tax
     */
    public function getAmount();

    /**
     * Sets amount with tax.
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return $this Self object
     */
    public function setAmount(MoneyInterface $amount);

    /**
     * Gets coupon amount with tax.
     *
     * @return MoneyInterface|null price with tax
     */
    public function getCouponAmount();

    /**
     * Sets coupon amount with tax.
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return $this Self object
     */
    public function setCouponAmount(MoneyInterface $amount);

    /**
     * Gets the shipping amount.
     *
     * @return MoneyInterface Shipping amount with tax
     */
    public function getShippingAmount();

    /**
     * Sets the shipping amount.
     *
     * @param MoneyInterface $shippingAmount shipping amount with tax
     *
     * @return $this Self object
     */
    public function setShippingAmount(MoneyInterface $shippingAmount);

    /**
     * Gets purchasable amount with tax.
     *
     * @return MoneyInterface price with tax
     */
    public function getPurchasableAmount();

    /**
     * Sets purchasable amount with tax.
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return $this Self object
     */
    public function setPurchasableAmount(MoneyInterface $amount);

    /**
     * Returns the customer.
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer();

    /**
     * Sets the customer.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return $this Self object
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Sets cart lines.
     *
     * @param Collection $cartLines Cart Lines
     *
     * @return $this Self object
     */
    public function setCartLines(Collection $cartLines);

    /**
     * Gets lines.
     *
     * @return Collection CartLine collection
     */
    public function getCartLines();

    /**
     * Adds a Cart Line.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return $this Self object
     */
    public function addCartLine(CartLineInterface $cartLine);

    /**
     * Removes a Cart Line from this Cart.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return $this Self object
     */
    public function removeCartLine(CartLineInterface $cartLine);

    /**
     * Sets an Order to this Cart.
     *
     * @param OrderInterface $order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Gets Cart Order.
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Sets the ordered flag.
     *
     * @param bool $ordered Has been ordered
     *
     * @return $this Self object
     */
    public function setOrdered($ordered);

    /**
     * Tells if this cart has been converted to an Order.
     *
     * @return bool is ordered
     */
    public function isOrdered();

    /**
     * Return the total amount of items added to the Cart.
     *
     * @return int
     */
    public function getTotalItemNumber();

    /**
     * Get DeliveryAddress.
     *
     * @return AddressInterface DeliveryAddress
     */
    public function getDeliveryAddress();

    /**
     * Sets DeliveryAddress.
     *
     * @param AddressInterface $deliveryAddress DeliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress);

    /**
     * Get BillingAddress.
     *
     * @return AddressInterface BillingAddress
     */
    public function getBillingAddress();

    /**
     * Sets BillingAddress.
     *
     * @param AddressInterface $billingAddress BillingAddress
     *
     * @return $this Self object
     */
    public function setBillingAddress(AddressInterface $billingAddress);

    /**
     * Get shipping method.
     *
     * @return string Shipping method
     */
    public function getShippingMethod();

    /**
     * Set shipping method.
     *
     * @param string $shippingMethod Shipping method
     *
     * @return $this Self object
     */
    public function setShippingMethod($shippingMethod);

    /**
     * Get shipping method.
     *
     * @return string Cheapest shipping method
     */
    public function getCheapestShippingMethod();

    /**
     * Sets ShippingRange.
     *
     * @param string $cheapestShippingMethod Cheapest shipping method
     *
     * @return $this Self object
     */
    public function setCheapestShippingMethod($cheapestShippingMethod);
}
