<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Bundle\CouponBundle\Tests\Functional\app;

use Elcodi\Bundle\TestCommonBundle\Functional\Abstracts\AbstractElcodiKernel;

/**
 * Class AppKernel
 */
class AppKernel extends AbstractElcodiKernel
{
    /**
     * Register application bundles
     *
     * @return array Array of bundles instances
     */
    public function registerBundles()
    {
        $bundles = array(

            /**
             * Symfony bundles
             */
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),

            /**
             * Doctrine bundles
             */
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            /**
             * Elcodi core bundles
             */
            new \Elcodi\Bundle\CoreBundle\ElcodiCoreBundle(),
            new \Elcodi\Bundle\CouponBundle\ElcodiCouponBundle(),
            new \Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle(),
            new \Elcodi\Bundle\RuleBundle\ElcodiRuleBundle(),
        );

        return $bundles;
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
