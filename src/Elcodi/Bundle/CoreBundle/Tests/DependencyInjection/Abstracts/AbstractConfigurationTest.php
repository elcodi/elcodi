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

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

class AbstractConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractConfiguration
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = $this
            ->getMockBuilder('Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    public function testGetConfigTreeBuilder()
    {
        $configTreeBuilder = $this->object->getConfigTreeBuilder();

        $this->assertInstanceOf(
            'Symfony\Component\Config\Definition\Builder\TreeBuilder',
            $configTreeBuilder
        );
    }
}
