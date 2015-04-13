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

namespace Elcodi\Component\Core\Router;

use RuntimeException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class SingleRouterLoader
 */
class SingleRouterLoader implements LoaderInterface
{
    /**
     * @var string
     *
     * Route name
     */
    protected $controllerRouteName;

    /**
     * @var string
     *
     * Controller route
     */
    protected $controllerRoute;

    /**
     * @var string
     *
     * Controller action
     */
    protected $controllerAction;

    /**
     * @var string
     *
     * Resource type
     */
    protected $resourceType;

    /**
     * @var boolean
     *
     * Route is loaded
     */
    protected $loaded = false;

    /**
     * @var array
     *
     * Route options
     */
    protected $options;

    /**
     * Construct method
     *
     * @param string $controllerRouteName controller route name
     * @param string $controllerRoute     controller route
     * @param string $controllerAction    controller action
     * @param string $resourceType        resource type
     * @param array  $options             route options
     */
    public function __construct(
        $controllerRouteName,
        $controllerRoute,
        $controllerAction,
        $resourceType,
        array $options = []
    ) {
        $this->controllerRouteName = $controllerRouteName;
        $this->controllerRoute = $controllerRoute;
        $this->controllerAction = $controllerAction;
        $this->resourceType = $resourceType;
        $this->options = $options;
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

        $defaults = array_merge(['_controller' => $this->controllerAction], $this->options);

        $routes->add($this->controllerRouteName, new Route($this->controllerRoute, $defaults));

        $this->loaded = true;

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
        return $this->resourceType === $type;
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
