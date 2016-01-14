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

namespace Elcodi\Component\Payment\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Payment\Entity\PaymentMethod;

/**
 * Class PaymentCollectionEvent.
 */
final class PaymentCollectionEvent extends Event
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    private $cart;

    /**
     * Construct.
     *
     * @param CartInterface $cart Cart
     */
    public function __construct(CartInterface $cart = null)
    {
        $this->cart = $cart;
    }

    /**
     * @var PaymentMethod[]
     *
     * Payment methods
     */
    protected $paymentMethods = [];

    /**
     * Get cart.
     *
     * @return CartInterface $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Add payment method.
     *
     * @param PaymentMethod $paymentMethod Payment method
     *
     * @return $this Self object
     */
    public function addPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethods[] = $paymentMethod;

        return $this;
    }

    /**
     * Get payment methods.
     *
     * @return PaymentMethod[] Payment methods
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }
}
