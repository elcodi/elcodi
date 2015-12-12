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

namespace Elcodi\Bundle\CoreBundle\Tests\DependencyInjection;

use PHPUnit_Framework_Assert;

use Elcodi\Bundle\CoreBundle\DependencyInjection\ElcodiCoreExtension;
use Elcodi\Bundle\CoreBundle\Tests\DependencyInjection\Abstracts\AbstractExtensionTest;

class ElcodiCoreExtensionTest extends AbstractExtensionTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();

        $this->object = new ElcodiCoreExtension();
    }

    public function testGetConfiguration()
    {
        $containerBuilder = $this->getMock(self::CONTAINER_BUILDER);

        $configuration = $this->object->getConfiguration([], $containerBuilder);

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\DependencyInjection\Configuration',
            $configuration
        );
        $this->assertInstanceOf(
            'Symfony\Component\Config\Definition\ConfigurationInterface',
            $configuration
        );

        $this->assertSame(
            'elcodi_core',
            PHPUnit_Framework_Assert::readAttribute($configuration, 'extensionName')
        );
    }

    public function testGetConfigFilesLocation()
    {
        $configFilesLocation = $this->object->getConfigFilesLocation();

        $this->assertInternalType('string', $configFilesLocation);
        $this->assertFileExists($configFilesLocation);
    }

    public function testGetConfigFiles()
    {
        $configFilesLocation = $this->object->getConfigFilesLocation();
        $configFiles = $this->object->getConfigFiles([]);

        $this->assertInternalType('array', $configFiles);
        $this->assertContainsOnly('string', $configFiles);

        foreach ($configFiles as $configFile) {
            $this->assertFileExists(
                $configFilesLocation . DIRECTORY_SEPARATOR . $configFile . '.yml'
            );
        }
    }
}
