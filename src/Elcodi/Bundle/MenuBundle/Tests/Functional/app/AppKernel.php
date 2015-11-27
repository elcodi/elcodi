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

namespace Elcodi\Bundle\MenuBundle\Tests\Functional\app;

use Elcodi\Bundle\CoreBundle\Traits\BundleDependenciesResolver;
use Elcodi\Bundle\TestCommonBundle\Functional\Abstracts\AbstractElcodiKernel;

/**
 * Class AppKernel
 */
class AppKernel extends AbstractElcodiKernel
{
    use BundleDependenciesResolver;

    /**
     * Register application bundles
     *
     * @return array Array of bundles instances
     */
    public function registerBundles()
    {
        return $this->getBundleInstances($this, [
            'Symfony\Bundle\FrameworkBundle\FrameworkBundle',
            'Doctrine\Bundle\DoctrineBundle\DoctrineBundle',
            'Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle',
            'Elcodi\Bundle\FixturesBoosterBundle\ElcodiFixturesBoosterBundle',
            'Elcodi\Bundle\MenuBundle\ElcodiMenuBundle',
        ]);
    }

    /**
     * Gets the container class.
     *
     * @return string The container class
     */
    protected function getContainerClass()
    {
        return  $this->name .
                ucfirst($this->environment) .
                'DebugProjectContainerMenu';
    }
}
