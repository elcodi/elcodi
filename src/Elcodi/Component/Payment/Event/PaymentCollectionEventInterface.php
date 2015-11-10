<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Payment\Entity\PaymentMethod;

/**
 * Interface PaymentCollectionEventInterface
 */
interface PaymentCollectionEventInterface
{
    /**
     * Get cart
     *
     * @return CartInterface $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Add payment method
     *
     * @param PaymentMethod $paymentMethod Payment method
     *
     * @return $this Self object
     */
    public function addPaymentMethod(PaymentMethod $paymentMethod);

    /**
     * Get payment methods
     *
     * @return PaymentMethod[] Payment methods
     */
    public function getPaymentMethods();
}
