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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CoreBundle\Traits;

use ReflectionClass;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Trait BundleDependenciesResolver
 */
trait BundleDependenciesResolver
{
    /**
     * Get bundle instances given the namespace stack
     *
     * @param array $bundleNamespaces Bundle namespaces
     *
     * @return Bundle[] Bundle instances
     */
    protected function getBundleInstances(array $bundleNamespaces)
    {
        $bundles = [];
        $bundlesNamespacesStack = [];
        $bundleNamespacesResolved = $this
            ->resolveBundleDependencies(
                $bundlesNamespacesStack,
                $bundleNamespaces
            );

        foreach ($bundleNamespacesResolved as $bundleNamespace) {
            $bundles[] = new $bundleNamespace($this);
        }

        return $bundles;
    }

    /**
     * Resolve bundle dependencies
     *
     * @param array $bundlesNamespacesStack Bundle Namespace stack
     * @param array $bundleNamespaces       New bundles to check
     *
     * @return array Bundle Namespaces resolved
     */
    protected function resolveBundleDependencies(array &$bundlesNamespacesStack, array $bundleNamespaces)
    {
        foreach ($bundleNamespaces as $bundleNamespace) {
            $bundlesNamespacesStack[] = $bundleNamespace;
            $bundleNamespaceObj = new ReflectionClass($bundleNamespace);
            if ($bundleNamespaceObj->implementsInterface('\Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface')) {

                /**
                 * @var \Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface $bundleNamespace
                 */
                $dependencies = $bundleNamespace::getBundleDependencies();
                $newBundles = array_diff(
                    $dependencies,
                    $bundlesNamespacesStack
                );

                if (!empty($newBundles)) {
                    $bundleNamespaces = array_merge(
                        $bundleNamespaces,
                        self::resolveBundleDependencies(
                            $bundlesNamespacesStack,
                            $newBundles
                        )
                    );
                }
            }
        }

        return array_unique($bundleNamespaces);
    }
}
