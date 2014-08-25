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
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use Elcodi\Component\Menu\Adapter\RouteGenerator\SymfonyRouteGeneratorAdapter;

/**
 * Class SymfonyRouteGeneratorAdapterTest
 */
class SymfonyRouteGeneratorAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SymfonyRouteGeneratorAdapter
     *
     * Adapter
     */
    protected $symfonyRouteGeneratorAdapter;

    /**
     * Set up
     */
    public function setUp()
    {
        $urlGenerator = $this
            ->getMock('Symfony\Component\Routing\Generator\UrlGeneratorInterface');

        $urlGenerator
            ->expects($this->any())
            ->method('generate')
            ->will($this->returnCallback(function ($value) {

                if (true === $value) {

                    throw new RouteNotFoundException;
                }

                switch ($value) {

                    case 'route1':
                        return '/my/route1';
                        break;
                    default:
                        throw new RouteNotFoundException;
                }
            }));

        $this->symfonyRouteGeneratorAdapter = new SymfonyRouteGeneratorAdapter($urlGenerator);
    }

    /**
     * Test generate url
     *
     * @dataProvider dataGenerateUrl
     */
    public function testGenerateUrl($route, $url)
    {
        $this->assertEquals(
            $url,
            $this->symfonyRouteGeneratorAdapter->generateUrl($route)
        );
    }

    /**
     * data for testGenerateUrl
     *
     * @return array Data
     */
    public function dataGenerateUrl()
    {
        return [
            ['', ''],
            [false, ''],
            [null, ''],
            [true, 1],
            ['route1', '/my/route1'],
            ['route2', 'route2'],
            ['route3', 'route3'],
        ];
    }
}
