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

namespace Elcodi\Bundle\CoreBundle\Tests\Abstracts;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;

class AbstractElcodiBundleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Bundle
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = $this->getMock('Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle');
    }

    public function testBuild()
    {
        $containerBuilder = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');

        $this->object->build($containerBuilder);
    }

    public function testRegisterCommands()
    {
        $application = $this->getMock('Symfony\Component\Console\Application');

        $commands = $this->object->registerCommands($application);

        $this->assertNull($commands);
    }
}
