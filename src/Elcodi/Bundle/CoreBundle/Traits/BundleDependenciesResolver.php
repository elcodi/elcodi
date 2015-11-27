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

namespace Elcodi\Bundle\CoreBundle\Traits;

@trigger_error('Warning. This feature is extracted from Elcodi and placed in the
repository mmoreram/symfony-bundle-dependencies. Will be removed permanently in
v2.0.0.', E_USER_DEPRECATED);

/**
 * Trait BundleDependenciesResolver
 */
trait BundleDependenciesResolver
{
    /**
     * Get bundle instances given the namespace stack
     *
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel  Kernel
     * @param array                                         $bundles Bundles defined by instances or namespaces
     *
     * @return \Symfony\Component\HttpKernel\Bundle\Bundle[] Bundle instances
     */
    protected function getBundleInstances(
        \Symfony\Component\HttpKernel\KernelInterface $kernel,
        array $bundles
    ) {
        $bundleStack = [];
        $visitedBundles = [];
        $this
            ->resolveBundleDependencies(
                $kernel,
                $bundleStack,
                $visitedBundles,
                $bundles
            );

        $builtBundles = [];
        foreach ($bundleStack as $bundle) {
            $builtBundles[] = $this
                ->getBundleDefinitionInstance($bundle);
        }

        return $builtBundles;
    }

    /**
     * Resolve bundle dependencies.
     *
     * Given a set of already loaded bundles and a set of new needed bundles,
     * build new dependencies and fill given array of loaded bundles.
     *
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel         Kernel
     * @param array                                         $bundleStack    Bundle stack, defined by Instance or Namespace
     * @param array                                         $visitedBundles Visited bundles, defined by their namespaces
     * @param array                                         $bundles        New bundles to check, defined by Instance or Namespace
     */
    private function resolveBundleDependencies(
        \Symfony\Component\HttpKernel\KernelInterface $kernel,
        array &$bundleStack,
        array &$visitedBundles,
        array $bundles
    ) {
        $bundles = array_reverse($bundles);

        foreach ($bundles as $bundle) {

            /**
             * Each visited node is prioritized and placed at the beginning.
             */
            $this
                ->prioritizeBundle(
                    $bundleStack,
                    $bundle
                );
        }

        foreach ($bundles as $bundle) {
            $bundleNamespace = $this->getBundleDefinitionNamespace($bundle);
            /**
             * If have already visited this bundle, continue. One bundle can be
             * processed once.
             */
            if (isset($visitedBundles[$bundleNamespace])) {
                continue;
            }

            $visitedBundles[$bundleNamespace] = true;
            $bundleNamespaceObj = new \ReflectionClass($bundleNamespace);
            if (
                $bundleNamespaceObj->implementsInterface('Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface') ||
                $bundleNamespaceObj->implementsInterface('Mmoreram\SymfonyBundleDependencies\DependentBundleInterface')
            ) {

                /**
                 * @var \Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface|string $bundleNamespace
                 */
                $bundleDependencies = $bundleNamespace::getBundleDependencies($kernel);

                $this->resolveBundleDependencies(
                    $kernel,
                    $bundleStack,
                    $visitedBundles,
                    $bundleDependencies
                );
            }
        }
    }

    /**
     * Given the global bundle stack and a bundle definition, considering this
     * bundle definition as an instance or a namespace, prioritize this bundle
     * inside this stack.
     *
     * To prioritize a bundle means that must be placed in the beginning of the
     * stack. If already exists, then remove the old entry just before adding it
     * again.
     *
     * @param array                                              $bundleStack         Bundle stack, defined by Instance or Namespace
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle|string $elementToPrioritize Element to prioritize
     */
    private function prioritizeBundle(
        array &$bundleStack,
        $elementToPrioritize
    ) {
        $elementNamespace = $this->getBundleDefinitionNamespace($elementToPrioritize);
        foreach ($bundleStack as $bundlePosition => $bundle) {
            $bundleNamespace = $this->getBundleDefinitionNamespace($bundle);

            if ($elementNamespace == $bundleNamespace) {
                unset($bundleStack[$bundlePosition]);
            }
        }
        array_unshift($bundleStack, $elementToPrioritize);
    }

    /**
     * Given a bundle instance or a namespace, return its namespace
     *
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle|string $bundle Bundle defined by Instance or Namespace
     *
     * @return string Bundle namespace
     */
    private function getBundleDefinitionNamespace($bundle)
    {
        return ltrim(is_object($bundle)
            ? get_class($bundle)
            : $bundle, ' \\');
    }

    /**
     * Given a bundle instance or a namespace, return the instance
     *
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle|string $bundle Bundle defined by Instance or Namespace
     *
     * @return \Symfony\Component\HttpKernel\Bundle\Bundle Bundle instance
     */
    private function getBundleDefinitionInstance($bundle)
    {
        return is_object($bundle)
            ? $bundle
            : new $bundle();
    }
}
