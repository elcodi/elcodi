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

namespace Elcodi\Component\Plugin\Loader;

use RuntimeException;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Exception\PluginNotFoundException;

/**
 * Class RouterLoader.
 */
class RouterLoader extends Loader
{
    /**
     * @var bool
     *
     * Route is loaded
     */
    private $loaded = false;

    /**
     * @var Plugin[]
     *
     * Plugins
     */
    private $plugins;

    /**
     * @var KernelInterface
     *
     * Kernel
     */
    private $kernel;

    /**
     * Construct.
     *
     * @param KernelInterface $kernel  Kernel
     * @param Plugin[]        $plugins Plugins
     */
    public function __construct(
        KernelInterface $kernel,
        array $plugins
    ) {
        $this->kernel = $kernel;
        $this->plugins = $plugins;
    }

    /**
     * Loads a resource.
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @return RouteCollection
     *
     * @throws RuntimeException Loader is added twice
     */
    public function load($resource, $type = null)
    {
        if ($this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        $routes->addCollection(
            $this->addPluginsRoutesCollection()
        );

        $this->loaded = true;

        return $routes;
    }

    /**
     * Return route collection for injected plugins.
     *
     * @return RouteCollection Collection generated
     */
    protected function addPluginsRoutesCollection()
    {
        $routes = new RouteCollection();

        foreach ($this->plugins as $plugin) {
            if (!$plugin->exists()) {
                throw PluginNotFoundException::createPluginRouteNotFound($plugin);
            }

            $routes->addCollection(
                $this->addPluginRoutesCollection($plugin)
            );
        }

        return $routes;
    }

    /**
     * Return route collection for injected plugins.
     *
     * @return RouteCollection Collection generated
     */
    protected function addPluginRoutesCollection(Plugin $plugin)
    {
        $routes = new RouteCollection();
        $bundleName = $plugin->getBundleName();
        $bundle = $this
            ->kernel
            ->getBundle($bundleName);

        $routingFilePath = '/Resources/config/routing.yml';
        $resourcePath = $bundle->getPath() . $routingFilePath;
        $type = 'yaml';

        if (file_exists($resourcePath)) {
            $routes->addCollection(
                $this
                ->import(
                    '@' . $bundle->getName() . $routingFilePath,
                    $type
                )
            );
        }

        return $routes;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'elcodi.routes.plugins' === $type;
    }
}
