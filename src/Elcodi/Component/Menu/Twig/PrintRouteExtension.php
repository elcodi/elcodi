<?php

/**
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

namespace Elcodi\Component\Menu\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Menu\Adapter\RouteGenerator\Interfaces\RouteGeneratorAdapterInterface;

/**
 * Class PrintRouteExtension
 *
 * Twig extension that uses an adapter to return an URL.
 *
 * This is used in the menu component to interpret the content of
 * the MenuNode::url. It could be, for example, a plain URL or a
 * named Symfony route. The dependency on the Twig_Extension
 * is optional, and so it should be the dependency on the symfony
 * Router component.
 */
class PrintRouteExtension extends Twig_Extension
{
    /**
     * @var RouteGeneratorAdapterInterface
     *
     * Adapter used to generate the route
     */
    protected $routeGeneratorAdapter;

    /**
     * The constructor needs an adapter that can return an URL.
     *
     * @param RouteGeneratorAdapterInterface $routeGeneratorAdapter route generator adapter
     */
    public function __construct(RouteGeneratorAdapterInterface $routeGeneratorAdapter)
    {
        $this->routeGeneratorAdapter = $routeGeneratorAdapter;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[] An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('generate_url', array($this, 'printUrl'))
        ];
    }

    /**
     * Returns an URL given a string representing a route.
     *
     * @param string $route route name to be converted to an URL
     *
     * @return string
     */
    public function printUrl($route)
    {
        return $this
            ->routeGeneratorAdapter
            ->generateUrl($route);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'print_route_extension';
    }
}
