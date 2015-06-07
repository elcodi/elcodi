<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Elcodi\Component\Payment\Entity\PaymentMethod;

/**
 * Class PaymentCollectionEvent
 */
class PaymentCollectionEvent extends Event
{
    /**
     * @var PaymentMethod[]
     *
     * Payment methods
     */
    protected $paymentMethods = [];

    /**
     * Add payment method
     *
     * @param PaymentMethod $paymentMethod Payment method
     *
     * @return $this Self object
     */
    public function addPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethods[] =  $paymentMethod;

        return $this;
    }

    /**
     * Get payment methods
     *
     * @return PaymentMethod[] Payment methods
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }
}
