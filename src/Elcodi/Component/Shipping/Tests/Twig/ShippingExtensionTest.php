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

namespace Elcodi\Component\Shipping\Tests\Twig;

use Twig_ExtensionInterface;
use Twig_Test_IntegrationTestCase;

use Elcodi\Component\Shipping\Twig\ShippingExtension;

class ShippingExtensionTest extends Twig_Test_IntegrationTestCase
{
    /**
     * @return Twig_ExtensionInterface[]
     */
    public function getExtensions()
    {
        $shippingWrapper = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Wrapper\ShippingWrapper')
            ->disableOriginalConstructor()
            ->getMock();

        return [
            new ShippingExtension($shippingWrapper),
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
