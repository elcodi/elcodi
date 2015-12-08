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

namespace Elcodi\Bundle\AttributeBundle\Tests;

use Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle;
use Elcodi\Bundle\CoreBundle\Tests\Abstracts\AbstractElcodiBundleTest;

class ElcodiAttributeBundleTest extends AbstractElcodiBundleTest
{
    use \Elcodi\Bundle\CoreBundle\Tests\Interfaces\DependentBundleInterfaceTrait;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ElcodiAttributeBundle();
    }

    public function testGetContainerExtension()
    {
        $containerExtension = $this->object->getContainerExtension();

        $this->assertInstanceOf(
            'Symfony\Component\DependencyInjection\Extension\ExtensionInterface',
            $containerExtension
        );
    }
}
