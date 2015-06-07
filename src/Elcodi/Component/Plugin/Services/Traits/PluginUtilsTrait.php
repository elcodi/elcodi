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

namespace Elcodi\Component\Plugin\Services\Traits;

/**
 * Trait PluginUtilsTrait
 */
trait PluginUtilsTrait
{
    /**
     * Load installed plugin bundles and return an array with them, indexed by
     * their namespaces
     *
     * @return \Elcodi\Component\Plugin\Interfaces\PluginInterface[]|\Symfony\Component\HttpKernel\Bundle\Bundle[] Plugins installed
     */
    protected function getInstalledPluginBundles(\Symfony\Component\HttpKernel\KernelInterface $kernel)
    {
        $plugins = [];
        $bundles = $kernel->getBundles();

        foreach ($bundles as $bundle) {

            /**
             * @var \Symfony\Component\HttpKernel\Bundle\Bundle|\Elcodi\Component\Plugin\Interfaces\PluginInterface $bundle
             */
            if ($bundle instanceof \Elcodi\Component\Plugin\Interfaces\PluginInterface) {
                $pluginNamespace = $bundle->getNamespace();
                $plugins[$pluginNamespace] = $bundle;
            }
        }

        return $plugins;
    }
}
