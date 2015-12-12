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

namespace Elcodi\Bundle\AttributeBundle\Tests\DependencyInjection;

use ExtensionInterface;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

use Elcodi\Bundle\AttributeBundle\DependencyInjection\ElcodiAttributeExtension;

class ElcodiAttributeExtensionTest extends AbstractExtensionTestCase
{
    use \Elcodi\Bundle\CoreBundle\Tests\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterfaceTrait;

    /**
     * Return an array of container extensions you need to be registered for each test (usually just the container
     * extension you are testing.
     *
     * @return ExtensionInterface[]
     */
    protected function getContainerExtensions()
    {
        return [
            new ElcodiAttributeExtension(),
        ];
    }

    /**
     * @var ElcodiAttributeExtension
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();

        $this->object = new ElcodiAttributeExtension();
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
