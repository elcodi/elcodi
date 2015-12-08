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

namespace Elcodi\Bundle\CoreBundle\Tests\DependencyInjection\Abstracts;

use PHPUnit_Framework_TestCase;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

class AbstractExtensionTest extends PHPUnit_Framework_TestCase
{
    const CONTAINER_BUILDER = 'Symfony\Component\DependencyInjection\ContainerBuilder';

    /**
     * @var AbstractExtension
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = $this->getMockForAbstractClass(
            'Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension'
        );
    }

    public function testGetConfiguration()
    {
        $containerBuilder = $this->getMock(self::CONTAINER_BUILDER);

        $configuration = $this->object->getConfiguration([], $containerBuilder);
        $this->assertNull($configuration);
    }

    public function testGetNamespace()
    {
        $namespace = $this->object->getNamespace();

        $this->assertInternalType('string', $namespace);
    }

    public function testGetXsdValidationBasePath()
    {
        $xsdValidationBasePath = $this->object->getXsdValidationBasePath();

        $this->assertInternalType('string', $xsdValidationBasePath);
    }
}
