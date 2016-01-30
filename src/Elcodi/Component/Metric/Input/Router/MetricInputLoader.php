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

namespace Elcodi\Component\Metric\Input\Router;

use RuntimeException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class MediaRouterLoader.
 */
class MetricInputLoader implements LoaderInterface
{
    /**
     * @var string
     *
     * Input route name
     */
    private $inputControllerRouteName;

    /**
     * @var string
     *
     * Input controller route
     */
    private $inputResizeControllerRoute;

    /**
     * @var bool
     *
     * Route is loaded
     */
    private $loaded = false;

    /**
     * Construct method.
     *
     * @param string $inputControllerRouteName   Input controller route name
     * @param string $inputResizeControllerRoute Input controller route
     */
    public function __construct(
        $inputControllerRouteName,
        $inputResizeControllerRoute
    ) {
        $this->inputControllerRouteName = $inputControllerRouteName;
        $this->inputResizeControllerRoute = $inputResizeControllerRoute;
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
            throw new RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        $routes->add($this->inputControllerRouteName, new Route($this->inputResizeControllerRoute, [
            '_controller' => 'elcodi.controller.metric_input:addEntryAction',
        ]));

        $this->loaded = true;

        return $routes;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return bool true if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'elcodi_metric_input' === $type;
    }

    /**
     * Gets the loader resolver.
     *
     * @return LoaderResolverInterface A LoaderResolverInterface instance
     */
    public function getResolver()
    {
    }

    /**
     * Sets the loader resolver.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface instance
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
    }
}
