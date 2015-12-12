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

namespace Elcodi\Component\Configuration\Tests\Twig;

use Twig_ExtensionInterface;
use Twig_Test_IntegrationTestCase;

use Elcodi\Component\Configuration\Twig\ConfigurationExtension;

class ConfigurationExtensionTest extends Twig_Test_IntegrationTestCase
{
    /**
     * @return Twig_ExtensionInterface[]
     */
    public function getExtensions()
    {
        $configurationManager = $this
            ->getMockBuilder('Elcodi\Component\Configuration\Services\ConfigurationManager')
            ->disableOriginalConstructor()
            ->getMock();

        return [
            new ConfigurationExtension($configurationManager),
        ];
    }

    /**
     * @return string
     */
    public function getFixturesDir()
    {
        return __DIR__ . '/Fixtures/';
    }

    public function testGetParameter()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
