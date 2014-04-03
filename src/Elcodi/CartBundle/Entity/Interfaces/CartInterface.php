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

namespace Elcodi\CartBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CartBundle\Entity\Interfaces\PriceInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Class CartInterface
 */
interface CartInterface extends PriceInterface
{
    /**
     * Return the customer
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer();

    /**
     * Set the customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return CartInterface self Object
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Set cart lines
     *
     * @param Collection $cartLines Cart Lines
     *
     * @return CartInterface self Object
     */
    public function setCartLines(Collection $cartLines);

    /**
     * Get lines
     *
     * @return Collection of CartLine
     */
    public function getCartLines();

    /**
     * Add Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartInterface self Object
     */
    public function addCartLine(CartLineInterface $cartLine);

    /**
     * Remove Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartInterface self Object
     */
    public function removeCartLine(CartLineInterface $cartLine);

    /**
     * Set order
     *
     * @param OrderInterface $order
     *
     * @return CartInterface self Object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return CartInterface self Object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity();
}
