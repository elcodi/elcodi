<?php

/*
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

namespace Elcodi\Component\Configuration\Tests\Services;

use Elcodi\Component\Configuration\Adapter\Interfaces\ParameterFetcherInterface;
use Elcodi\Component\Configuration\Services\ConfigurationManager;
use PHPUnit_Framework_TestCase;

class ConfigurationManagerTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    /**
     * @dataProvider dataParameters
     */
    public function testGetParameter($parameter, $value)
    {
        $testArrayParameters = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => NULL
        ];

        $configurationManager = new ConfigurationManager(new ArrayParameterFetcher($testArrayParameters));

        $this->assertEquals(
            $value,
            $configurationManager->getParameter($parameter)
        );
    }

    /**
     * Data provider for parameter data
     */
    public function dataParameters()
    {
        return [
            ['param1', 'value1'],
            ['param2', 'value2'],
            ['param3', NULL]
        ];
    }

}

class ArrayParameterFetcher implements ParameterFetcherInterface
{
    private $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($parameter)
    {
        return $this->parameters[$parameter];
    }
}