<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Bundle\ConfigurationBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
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
        return ['elcodi.manager.configuration'];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiConfigurationBundle',
        ];
    }

    /**
     * Test get value from existing value in database
     */
    public function testGetParameterExisting()
    {
        $this
            ->assertFalse(
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->contains('app.my_boolean_parameter')
            );

        $this
            ->assertInstanceOf(
                'Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface',
                $this->find('Configuration', [
                    'namespace' => 'app',
                    'key'       => 'my_boolean_parameter',
                ])
            );

        $this->assertEquals(
            true,
            $this
                ->get('my_class_parameter_boolean')
                ->getValue()
        );

        $this
            ->assertEquals(
                true,
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->fetch('app.my_boolean_parameter')
            );
    }

    /**
     * Test get value from non existing value in database
     */
    public function testGetParameterNonExisting()
    {
        $this
            ->assertFalse(
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->contains('my_parameter')
            );

        $this
            ->assertNull(
                $this->find('Configuration', [
                    'namespace' => '',
                    'key'       => 'my_parameter',
                ])
            );

        $this->assertEquals(
            'my_parameter_value',
            $this
                ->get('my_class_parameter')
                ->getValue()
        );

        $this
            ->assertEquals(
                'my_parameter_value',
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->fetch('my_parameter')
            );

        $this
            ->assertInstanceOf(
                'Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface',
                $this->find('Configuration', [
                    'namespace' => '',
                    'key'       => 'my_parameter',
                ])
            );
    }

    /**
     * Tests getting a non-existing parameter
     *
     * @expectedException \Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException
     */
    public function testGetNonExistingParameter()
    {
        $this
            ->get('elcodi.manager.configuration')
            ->get('non_existent_parameter');
    }

    /**
     * Test get value from previously inserted value in database
     */
    public function testGetParameterInsertedExisting()
    {
        $this
            ->assertFalse(
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->contains('my_parameter')
            );

        $this
            ->get('elcodi.manager.configuration')
            ->set('my_parameter', 'my_new_value');

        $this
            ->assertInstanceOf(
                'Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface',
                $this->find('Configuration', [
                    'namespace' => '',
                    'key'       => 'my_parameter',
                ])
            );

        $this->assertEquals(
            'my_new_value',
            $this
                ->get('my_class_parameter')
                ->getValue()
        );

        $this
            ->assertEquals(
                'my_new_value',
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->fetch('my_parameter')
            );
    }

    /**
     * Test write immutable value with different value than expected
     *
     * @expectedException \Elcodi\Component\Configuration\Exception\ConfigurationNotEditableException
     */
    public function testImmutableConfigurationWrite()
    {
        $this
            ->assertFalse(
                $this
                    ->get('doctrine_cache.providers.elcodi_configurations')
                    ->contains('my_immutable_parameter')
            );

        $this
            ->get('elcodi.manager.configuration')
            ->set('my_immutable_parameter', 'immutable');

        $this
            ->assertEquals(
                'immutable',
                $this
                    ->find('Configuration', [
                        'namespace' => '',
                        'key'       => 'my_immutable_parameter',
                    ])
                    ->getValue()
            );

        $this
            ->get('elcodi.manager.configuration')
            ->set('my_immutable_parameter', 'non-immutable');
    }

    /**
     * Test deletion of an immutable parameter
     *
     * @expectedException \Elcodi\Component\Configuration\Exception\ConfigurationNotEditableException
     */
    public function testImmutableConfigurationDelete()
    {
        $this
            ->get('elcodi.manager.configuration')
            ->delete('my_immutable_parameter');
    }

    /**
     * Test parameter deletion
     */
    public function testDeleteParameter()
    {
        /*
         * Deletion of a non-persisted parameter should return false
         */
        $this
            ->assertFalse(
                $this
                    ->get('elcodi.manager.configuration')
                    ->delete('my_parameter')
            );

        /*
         * Deletion of a persisted parameter should return true
         */
        $this
            ->get('elcodi.manager.configuration')
            ->set('my_parameter', 'my_new_value');
        $this
            ->assertTrue(
                $this
                    ->get('elcodi.manager.configuration')
                    ->delete('my_parameter')
            );

        /*
         * Deleted parameter should not be found in cache
         */
        $this
            ->assertFalse(
              $this
                  ->get('doctrine_cache.providers.elcodi_configurations')
                  ->contains('my_parameter')
            );

        /*
         * Deleted parameter should be flushed from the DB
         */
        $this->assertNull(
            $this
                ->get('elcodi.repository.configuration')
                ->find([
                    'namespace' => '',
                    'key'       => 'my_parameter',
                ])
            );
    }

    /**
     * Test deletion of a non-existing parameter
     *
     * @expectedException \Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException
     */
    public function testDeleteNonExistentParameter()
    {
        $this
            ->get('elcodi.manager.configuration')
            ->delete('non_existent_parameter');
    }
}
