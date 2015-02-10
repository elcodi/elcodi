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

namespace Elcodi\Component\Page\Router;

use RuntimeException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class PageRouterSimpleLoader
 *
 * @author Berny Cantos <be@rny.cc>
 */
class PageRouterSimpleLoader implements LoaderInterface
{
    /**
     * @var string
     *
     * Page route name
     */
    protected $routeName;

    /**
     * @var string
     *
     * Page route path
     */
    protected $routePath;

    /**
     * @var string
     *
     * Controller name for rendering
     */
    protected $controller;

    /**
     * Construct method
     *
     * @param string $routeName  Page route name
     * @param string $routePath  Page route path
     * @param string $controller Controller name
     */
    public function __construct(
        $routeName,
        $routePath,
        $controller
    )
    {
        $this->routeName = $routeName;
        $this->routePath = $routePath;
        $this->controller = $controller;
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
        $routes = new RouteCollection();

        $route = new Route(
            $this->routePath,
            ['_controller' => $this->controller],
            ['path' => '[^/]+(?>/[^/]+)*+']
        );

        $routes->add($this->routeName, $route);

        return $routes;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return boolean true if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'elcodi_page_render' === $type;
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
