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

namespace Elcodi\Component\Payment\Tests\Twig;

use Twig_ExtensionInterface;
use Twig_Test_IntegrationTestCase;

use Elcodi\Component\Payment\Twig\PaymentExtension;

class PaymentExtensionTest extends Twig_Test_IntegrationTestCase
{
    /**
     * @return Twig_ExtensionInterface[]
     */
    public function getExtensions()
    {
        $paymentWrapper = $this
            ->getMockBuilder('Elcodi\Component\Payment\Wrapper\PaymentWrapper')
            ->disableOriginalConstructor()
            ->getMock();

        return [
            new PaymentExtension($paymentWrapper),
        ];
    }

    /**
     * @return string
     */
    public function getFixturesDir()
    {
        return __DIR__ . '/Fixtures/';
    }
}
