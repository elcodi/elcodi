<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Bundle\MenuBundle\Tests\Functional\Twig;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class PrintRouteExtensionTest
 */
class PrintRouteExtensionTest extends WebTestCase
{
    /**
     * Skipping tests if Twig is not installed
     */
    public function setUp()
    {
        parent::setUp();

        if (!class_exists('Twig_Extension')) {

            $this->markTestSkipped("Twig extension not installed");
        }
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.menu.twig_extension.print_route'
        ];
    }

    /**
     * Test print url
     */
    public function testPrintUrl()
    {
        $printRouteExtension = $this
            ->get('elcodi.core.menu.twig_extension.print_route');

        $this->assertEquals('route', $printRouteExtension->printUrl('route'));
    }
}
