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

namespace Elcodi\CartBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Class CartInterface
 */
interface CartInterface extends DateTimeInterface
{
    /**
     * Gets amount with tax
     *
     * @return MoneyInterface price with tax
     */
    public function getAmount();

    /**
     * Sets amount with tax
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return Object self Object
     */
    public function setAmount(MoneyInterface $amount);

    /**
     * Gets coupon amount with tax
     *
     * @return MoneyInterface price with tax
     */
    public function getCouponAmount();

    /**
     * Sets coupon amount with tax
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return Object self Object
     */
    public function setCouponAmount(MoneyInterface $amount);

    /**
     * Gets product amount with tax
     *
     * @return MoneyInterface price with tax
     */
    public function getProductAmount();

    /**
     * Sets product amount with tax
     *
     * @param MoneyInterface $amount price with tax
     *
     * @return Object self Object
     */
    public function setProductAmount(MoneyInterface $amount);

    /**
     * Returns the customer
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer();

    /**
     * Sets the customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return CartInterface self Object
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Sets cart lines
     *
     * @param Collection $cartLines Cart Lines
     *
     * @return CartInterface self Object
     */
    public function setCartLines(Collection $cartLines);

    /**
     * Gets lines
     *
     * @return Collection of CartLine
     */
    public function getCartLines();

    /**
     * Adds a Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartInterface self Object
     */
    public function addCartLine(CartLineInterface $cartLine);

    /**
     * Removes a Cart Line from this Cart
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartInterface self Object
     */
    public function removeCartLine(CartLineInterface $cartLine);

    /**
     * Sets an Order to this Cart
     *
     * @param OrderInterface $order
     *
     * @return CartInterface self Object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Gets Cart Order
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Sets the ordered flag
     *
     * @param boolean $ordered Has been ordered
     *
     * @return CartInterface self Object
     */
    public function setOrdered($ordered);

    /**
     * Tells if this cart has been converted to an Order
     *
     * @return boolean is ordered
     */
    public function isOrdered();

    /**
     * Sets the number of items on this cart
     *
     * @param int $quantity Quantity
     *
     * @return CartInterface self Object
     */
    public function setQuantity($quantity);

    /**
     * Gets the number of items on this cart
     *
     * @return integer Quantity
     */
    public function getQuantity();
}
