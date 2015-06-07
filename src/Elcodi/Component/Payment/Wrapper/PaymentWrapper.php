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

namespace Elcodi\Component\Payment\Wrapper;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Payment\EventDispatcher\PaymentEventDispatcher;

/**
 * Class PaymentWrapper
 */
class PaymentWrapper implements WrapperInterface
{
    /**
     * @var PaymentEventDispatcher
     *
     * Payment event dispatcher
     */
    protected $paymentEventDispatcher;

    /**
     * Construct
     *
     * @param PaymentEventDispatcher $paymentEventDispatcher Payment event dispatcher
     */
    public function __construct(PaymentEventDispatcher $paymentEventDispatcher)
    {
        $this->paymentEventDispatcher = $paymentEventDispatcher;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        return $this
            ->paymentEventDispatcher
            ->dispatchPaymentCollectionEvent();
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        return $this;
    }
}
