<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Plugin\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Entity\PluginConfiguration;

/**
 * Class PluginTest.
 */
class PluginTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->plugin = Plugin::create(
            'A\Plugin',
            'plugin',
            'social',
            PluginConfiguration::create([
                    'name' => 'A Plugin',
                    'description' => 'A plugin description',
                    'fa_icon' => 'plugin_icon',
                    'fields' => [
                        'field1' => [
                            'type' => 'text',
                            'label' => 'label1',
                            'required' => true,
                            'data' => null,
                            'options' => [],
                        ],
                        'field2' => [
                            'type' => 'boolean',
                            'label' => 'label2',
                            'required' => true,
                            'data' => false,
                            'options' => [],
                        ],
                    ],
                ]
            ),
            true
        );
    }

    /**
     * Test get configuration value.
     */
    public function testGetConfigurationValue()
    {
        $this->assertEquals(
            'A Plugin',
            $this->plugin->getConfigurationValue('name')
        );
    }

    /**
     * Test get fields.
     */
    public function testGetFields()
    {
        $this->assertEquals(
            [
                'field1' => [
                    'type' => 'text',
                    'label' => 'label1',
                    'required' => true,
                    'data' => null,
                    'options' => [],
                ],
                'field2' => [
                    'type' => 'boolean',
                    'label' => 'label2',
                    'required' => true,
                    'data' => false,
                    'options' => [],
                ],
            ],
            $this->plugin->getFields()
        );
    }

    /**
     * Test get fields.
     */
    public function testHasFields()
    {
        $this->assertTrue($this->plugin->hasFields());
    }

    /**
     * Test get field.
     */
    public function testGetField()
    {
        $this->assertEquals(
            [
                'type' => 'text',
                'label' => 'label1',
                'required' => true,
                'data' => null,
                'options' => [],
            ],
            $this->plugin->getField('field1')
        );
    }

    /**
     * Test has field.
     */
    public function testHasField()
    {
        $this->assertTrue($this->plugin->hasField('field1'));
        $this->assertTrue($this->plugin->hasField('field2'));
        $this->assertFalse($this->plugin->hasField('field3'));
    }

    /**
     * Test get field values.
     */
    public function testGetFieldValues()
    {
        $this->assertEquals(
            [
                'field1' => null,
                'field2' => false,
            ],
            $this->plugin->getFieldValues()
        );

        $this
            ->plugin
            ->getConfiguration()
            ->setFieldValue('field1', 'New value');

        $this->assertEquals(
            [
                'field1' => 'New value',
                'field2' => false,
            ],
            $this->plugin->getFieldValues()
        );
    }

    /**
     * Test get field value.
     */
    public function testGetFieldValue()
    {
        $this->assertEquals(
            null,
            $this->plugin->getFieldValue('field1')
        );

        $this
            ->plugin
            ->getConfiguration()
            ->setFieldValue('field1', 'New value');

        $this->assertEquals(
            'New value',
            $this->plugin->getFieldValue('field1')
        );
    }

    /**
     * Test set field values.
     */
    public function testSetFieldValues()
    {
        $this
            ->plugin
            ->setFieldValues([
                'field1' => 'New value',
                'field2' => false,
            ]);

        $this->assertEquals(
            [
                'field1' => 'New value',
                'field2' => false,
            ],
            $this->plugin->getFieldValues()
        );
    }

    /**
     * Test plugin is usable.
     */
    public function testIsUsable()
    {
        $plugin = $this->plugin;
        $configuration = $plugin->getConfiguration();

        $this->assertTrue($plugin->isUsable());
        $this->assertFalse($plugin->isUsable(['field3']));
        $this->assertFalse($plugin->isUsable(['field1']));
        $this->assertFalse($plugin->isUsable([
            'field1',
            'field3',
        ]));

        $configuration->setFieldValue('field1', 'Value');
        $configuration->setFieldValue('field2', true);
        $plugin->setEnabled(true);
        $this->assertTrue($plugin->isUsable([
            'field1',
            'field2',
        ]));

        $plugin->setEnabled(false);
        $this->assertFalse($plugin->isUsable());
        $this->assertFalse($plugin->isUsable(['field3']));
        $this->assertFalse($plugin->isUsable(['field1']));
        $this->assertFalse($plugin->isUsable([
            'field1',
            'field2',
        ]));
        $this->assertFalse($plugin->isUsable([
            'field1',
            'field3',
        ]));
    }

    /**
     * Test plugin can guess itself is usable.
     */
    public function testGuessIsUsable()
    {
        $plugin = $this->plugin;

        $this->assertFalse($plugin->guessIsUsable());
        $plugin->setEnabled(true);
        $this->assertFalse($plugin->guessIsUsable());
        $plugin->setFieldValues([
            'field1' => 'lala',
            'field2' => false,
        ]);
        $this->assertFalse($plugin->guessIsUsable());
        $plugin->setFieldValues([
            'field1' => 'lala',
            'field2' => true,
        ]);
        $this->assertTrue($plugin->guessIsUsable());
    }

    /**
     * Test merge.
     */
    public function testMergeOK()
    {
        $plugin = $this->plugin;
        $configuration = $plugin->getConfiguration();

        $configuration->setFieldValue('field1', 'value1');
        $mergedPlugin = $plugin
            ->merge(Plugin::create(
                'A\Plugin',
                'plugin',
                'social',
                PluginConfiguration::create([
                        'name' => 'A Plugin',
                        'description' => 'A plugin description',
                        'fa_icon' => 'plugin_icon',
                        'fields' => [
                            'field1' => [
                                'type' => 'text',
                                'label' => 'label1',
                                'required' => true,
                                'data' => null,
                                'options' => [],
                            ],
                            'field3' => [
                                'type' => 'textarea',
                                'label' => 'label3',
                                'required' => true,
                                'data' => null,
                                'options' => [],
                            ],
                        ],
                    ]
                ),
                true
            ));

        $this->assertEquals(
            'value1',
            $mergedPlugin->getFieldValue('field1')
        );

        $this->assertFalse($mergedPlugin->hasField('field2'));
        $this->assertTrue($mergedPlugin->hasField('field3'));
    }

    /**
     * Test merge with exception.
     *
     * @expectedException \RuntimeException
     */
    public function testMergeException()
    {
        $this
            ->plugin
            ->merge(
                Plugin::create(
                    'A\Nother\Plugin',
                    'plugin',
                    'social',
                    PluginConfiguration::create([
                            'name' => 'A Plugin',
                            'description' => 'A plugin description',
                            'fa_icon' => 'plugin_icon',
                            'fields' => [
                                'field1' => [
                                    'type' => 'text',
                                    'label' => 'label1',
                                    'required' => true,
                                    'data' => null,
                                    'options' => [],
                                ],
                            ],
                        ]
                    ),
                    true
                )
            );
    }

    /**
     * Test that the plugin namespace class exists.
     *
     * @group testplugin
     */
    public function testPluginExists()
    {
        $plugin = $this->getMock('Elcodi\Component\Plugin\Entity\Plugin', [
            'getNamespace',
        ], [], '', false);

        $plugin
            ->method('getNamespace')
            ->will($this->returnValue('Elcodi\Component\Plugin\Tests\Entity\PluginTest'));

        $this->assertTrue($plugin->exists());
    }

    /**
     * Test that the plugin namespace class not exists.
     *
     * @group testplugin
     */
    public function testPluginNotExists()
    {
        $plugin = $this->getMock('Elcodi\Component\Plugin\Entity\Plugin', [
            'getNamespace',
        ], [], '', false);

        $plugin
            ->method('getNamespace')
            ->will($this->returnValue('Elcodi\Component\Plugin\Tests\Entity\NonexistibgPluginTest'));

        $this->assertFalse($plugin->exists());
    }
}
