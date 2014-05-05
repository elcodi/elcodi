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

namespace Elcodi\CartBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CartBundle\Entity\Traits\PriceTrait;

/**
 * Cart
 */
class Cart extends AbstractEntity implements CartInterface
{
    use DateTimeTrait, PriceTrait;

    /**
     * @var CustomerInterface
     *
     * Doctrine mapping must be define in any instance
     */
    protected $customer;

    /**
     * @var OrderInterface
     *
     * The associated order entity. It is a one-one
     * relation and can be null on the Cart side
     */
    protected $order;

    /**
     * @var Collection
     *
     * Lines
     */
    protected $cartLines;

    /**
     * @var integer
     *
     * Quantity
     */
    protected $quantity;

    /**
     * Return the customer
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return Cart self Object
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Set order
     *
     * @param OrderInterface $order
     *
     * @return Cart self Object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set cart lines
     *
     * @param Collection $cartLines Cart Lines
     *
     * @return Cart self Object
     */
    public function setCartLines(Collection $cartLines)
    {
        $this->cartLines = $cartLines;

        return $this;
    }

    /**
     * Get lines
     *
     * @return Collection of CartLine
     */
    public function getCartLines()
    {
        return $this->cartLines;
    }

    /**
     * Add Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return Cart self Object
     */
    public function addCartLine(CartLineInterface $cartLine)
    {
        if (!$this->cartLines->contains($cartLine)) {

            $this->cartLines->add($cartLine);
        }

        return $this;
    }

    /**
     * Remove Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return Cart self Object
     */
    public function removeCartLine(CartLineInterface $cartLine)
    {
        $this->cartLines->removeElement($cartLine);

        return $this;
    }
    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return Cart self Object
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Return the total amount of items
     * added to the Cart
     *
     * @return integer
     */
    public function getTotalItemNumber() {
        return array_reduce($this->cartLines->toArray(), function($prev, $cur) { return $prev + $cur->getQuantity(); } );
    }
}
