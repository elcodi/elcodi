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

namespace Elcodi\Component\Payment\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Payment\Wrapper\PaymentWrapper;

/**
 * Class PaymentExtension.
 */
class PaymentExtension extends Twig_Extension
{
    /**
     * @var PaymentWrapper
     *
     * Payment wrapper
     */
    private $paymentWrapper;

    /**
     * Construct.
     *
     * @param PaymentWrapper $paymentWrapper Payment wrapper
     */
    public function __construct(PaymentWrapper $paymentWrapper)
    {
        $this->paymentWrapper = $paymentWrapper;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'elcodi_payment_methods',
                [$this->paymentWrapper, 'get']
            ),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'elcodi_payment';
    }
}
