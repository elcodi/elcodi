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

namespace Elcodi\Bundle\ConfigurationBundle\Tests\Functional\Services;

use Doctrine\ORM\EntityManager;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Configuration\Entity\Configuration;
use Elcodi\Component\Configuration\Services\ConfigurationManager;

/**
 * Class ConfigurationManagerTest
 */
class ConfigurationManagerTest extends WebTestCase
{
    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.configuration.service.configuration_manager',
            'elcodi.configuration_manager'
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiConfigurationBundle',
        );
    }

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->configurationManager = $this->get('elcodi.configuration_manager');
    }

    /**
     * Skips a test if the configuration provider is not Doctrine
     *
     * When using a different storage backend, it is useless to test
     * doctrine-specific behaviors
     */
    protected function skipIfConfigurationProviderIsNotDoctrine()
    {
        /*
         * We will skip the test if the configuration adapter
         * is not DoctrineConfigurationAdapter
         */
        $configurationManager = $this->get('elcodi.configuration_manager');
        $reflector = new \ReflectionObject($configurationManager);
        $property = $reflector->getProperty('configurationProvider');
        $property->setAccessible(true);

        $configurationProviderClass = get_class($property->getValue($configurationManager));

        if ('Elcodi\Component\Configuration\Adapter\DoctrineConfigurationProvider' != $configurationProviderClass) {
            $this->markTestSkipped('Skipping a doctrine specific test');
        }

    }

    /**
     * Test getParameter
     *
     * @param $namespace string Namespace of the parameter
     * @param $param     string Parameter Name
     * @param $value     string Parameter Value
     *
     * @dataProvider dataConfiguration
     */
    public function testGetParameter($namespace, $param, $value)
    {
        $this->skipIfConfigurationProviderIsNotDoctrine();

        /**
         * @var EntityManager
         */
        $manager = $this->get('elcodi.object_manager.configuration');

        /**
         * @var Configuration $parameter1
         */
        $parameter1 = $this
            ->get('elcodi.factory.configuration')
            ->create();
        $parameter1
            ->setNamespace($namespace)
            ->setParameter($param)
            ->setValue($value)
            ->setEnabled(true);
        $manager->persist($parameter1);

        $manager->flush($parameter1);

        $this->assertEquals(
            $value,
            $this
                ->configurationManager
                ->getParameter($param, $namespace)
        );
    }

    /**
     * @dataProvider dataConfiguration
     *
     * @param $namespace string namespace
     * @param $parameter string parameter name
     * @param $value     string parameter value
     */
    public function testSetParameter($namespace, $parameter, $value)
    {
        $this
            ->configurationManager
            ->setParameter($parameter, $value, $namespace);

        $this->assertEquals(
            $value,
            $this
                ->configurationManager
                ->getParameter($parameter, $namespace)
        );
    }

    /**
     * Tests a dynamically set parameter.
     *
     * See this test's app/config.yml for service definition
     *
     * These test services have their arguments injected via expression language
     * service() function that ask for elcodi.configuration_manager
     */
    public function testDynamicServiceParameter()
    {
        $this->skipIfConfigurationProviderIsNotDoctrine();

        /**
         * @var $serviceTest1 TestService
         */
        $serviceTest1 = $this->get('elcodi.configuration.test1');

        /*
         * Expected 'value1' comes from DataFixtures
         */
        $this->assertEquals(
            $serviceTest1->getParameterValue(),
            'value1'
        );

        $serviceTest2 = $this->get('elcodi.configuration.test2');

        $this->assertEquals(
            $serviceTest2->getParameterValue(),
            'default'
        );
    }

    /**
     * getParameter data provider
     */
    public function dataConfiguration()
    {
        return [
            ['', 'param1', 'value1'],
            ['namespace2', 'param2', 'value2'],
            [123, 'param3', 12345]
        ];
    }

}

class TestService
{
    protected $parameterValue;

    public function __construct($parameterValue)
    {
        $this->parameterValue = $parameterValue;
    }

    public function getParameterValue()
    {
        return $this->parameterValue;
    }
}
