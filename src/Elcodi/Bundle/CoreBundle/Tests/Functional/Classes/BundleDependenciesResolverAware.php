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

namespace Elcodi\Bundle\CoreBundle\Tests\Functional\Classes;

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
    public function getBundleNamespaces()
    {
        $dependenciesBundles = [];
        $bundles = [
            'Elcodi\Bundle\CoreBundle\Tests\Functional\Classes\Bundle3',
        ];

        return $this->resolveBundleDependencies($dependenciesBundles, $bundles);
    }
}
