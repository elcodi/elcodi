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

namespace Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Bundle\CoreBundle\Traits\BundleDependenciesResolver;

/**
 * Class BundleDependenciesResolverAware
 */
class BundleDependenciesResolverAware
{
    use BundleDependenciesResolver;

    /**
     * Get bundle instances
     *
     * @return Bundle[] Bundles
     */
    public function getInstancesTest1()
    {
        $bundles = [
            new \Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle3(),
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle5',
        ];

        return $this->getBundleInstances($bundles);
    }

    /**
     * Get bundle instances
     *
     * @return Bundle[] Bundles
     */
    public function getInstancesTest2()
    {
        $bundles = [
            new \Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle1(),
            'Elcodi\Bundle\CoreBundle\Tests\UnitTest\Classes\Bundle2',
        ];

        return $this->getBundleInstances($bundles);
    }
}
