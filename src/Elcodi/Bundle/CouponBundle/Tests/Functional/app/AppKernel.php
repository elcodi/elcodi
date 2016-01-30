<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\CouponBundle\Tests\Functional\app;

use Mmoreram\SymfonyBundleDependencies\CachedBundleDependenciesResolver;

use Elcodi\Bundle\TestCommonBundle\Functional\Abstracts\AbstractElcodiKernel;

/**
 * Class AppKernel.
 */
class AppKernel extends AbstractElcodiKernel
{
    use CachedBundleDependenciesResolver;

    /**
     * Register application bundles.
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
            'Elcodi\Bundle\CouponBundle\ElcodiCouponBundle',
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
                'DebugProjectContainerCoupon';
    }
}
