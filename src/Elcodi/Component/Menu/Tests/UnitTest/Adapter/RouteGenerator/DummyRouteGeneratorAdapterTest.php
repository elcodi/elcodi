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

namespace Elcodi\Component\Menu\Tests\UnitTest\Adapter\RouteGenerator;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Menu\Adapter\RouteGenerator\DummyRouteGeneratorAdapter;

/**
 * Class DummyRouteGeneratorAdapterTest
 */
class DummyRouteGeneratorAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test generate url
     */
    public function testGenerateUrl()
    {
        $routeGenerator = new DummyRouteGeneratorAdapter();
        $this->assertEquals('route', $routeGenerator->generateUrl('route'));
    }

}
