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

namespace Elcodi\Bundle\CoreBundle\Tests\Functional\Traits;

use PHPUnit_Framework_TestCase;

use Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\BundleDependenciesResolverAware;

/**
 * Class BundleDependenciesResolverTest
 */
class BundleDependenciesResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolver1
     */
    public function testResolver1()
    {
        $kernel = $this->prophesize('Symfony\Component\HttpKernel\KernelInterface');
        $bundleDependenciesResolver = new BundleDependenciesResolverAware();
        $bundles = $bundleDependenciesResolver->getInstancesTest1($kernel->reveal());

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle1',
            $bundles[0]
        );

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle2',
            $bundles[1]
        );

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle4',
            $bundles[2]
        );

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle5',
            $bundles[3]
        );
        $this->assertEquals('A', $bundles[3]->getValue());

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle3',
            $bundles[4]
        );
    }

    /**
     * Test resolver
     */
    public function testResolver2()
    {
        $kernel = $this->prophesize('Symfony\Component\HttpKernel\KernelInterface');
        $bundleDependenciesResolver = new BundleDependenciesResolverAware();
        $bundles = $bundleDependenciesResolver->getInstancesTest2($kernel->reveal());

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle1',
            $bundles[0]
        );

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle2',
            $bundles[1]
        );

        $this->assertInstanceOf(
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle5',
            $bundles[2]
        );
    }
}
