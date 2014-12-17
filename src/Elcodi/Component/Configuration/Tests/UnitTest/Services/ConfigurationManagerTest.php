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

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Configuration\Adapter\Interfaces\ConfigurationProviderInterface;
use Elcodi\Component\Configuration\Services\ConfigurationManager;

class ConfigurationManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests get Parameter
     *
     * @dataProvider dataParameters
     *
     * @param $parameter string parameter name
     * @param $value     string parameter value
     */
    public function testGetParameter($parameter, $value)
    {
        $testArrayParameters = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => NULL
        ];

        $configurationManager = new ConfigurationManager(
            new ArrayConfigurationProvider($testArrayParameters)
        );

        $this->assertEquals(
            $value,
            $configurationManager->getParameter($parameter)
        );
    }

    /**
     * Tests set Parameter
     *
     * @dataProvider dataParameters
     *
     * @param $parameter string parameter name
     * @param $value     string parameter value
     */
    public function testSetParameter($parameter, $value)
    {
        $configurationManager = new ConfigurationManager(
            new ArrayConfigurationProvider([])
        );

        $configurationManager->setParameter($parameter, $value);

        $this->assertEquals(
            $value,
            $configurationManager->getParameter($parameter)
        );
    }

    /**
     * Tests that a nonexistant parameter returns null
     */
    public function testGetNullParameter()
    {
        $configurationManager = new ConfigurationManager(
            new ArrayConfigurationProvider([])
        );

        $this->assertNull(
            $configurationManager->getParameter('parameter1')
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
            ['param3', null]
        ];
    }

}

class ArrayConfigurationProvider implements ConfigurationProviderInterface
{
    private $parameters = [];

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($parameter, $namespace = "")
    {
        if (!array_key_exists($parameter, $this->parameters)) {
            return null;
        }

        return $this->parameters[$parameter];
    }

    public function setParameter($parameter, $value, $namespace = "")
    {
        $this->parameters[$parameter] = $value;

        return $this;
    }
}
