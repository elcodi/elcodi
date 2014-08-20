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

namespace Elcodi\MenuBundle\Adapter\RouteGenerator;

use Symfony\Component\Routing\Router;

use Elcodi\MenuBundle\Adapter\RouteGenerator\Interfaces\RouteGeneratorAdapterInterface;

/**
 * Class SymfonyRouteGeneratorAdapter
 */
class SymfonyRouteGeneratorAdapter implements RouteGeneratorAdapterInterface
{
    /**
     * @var string
     *
     * Adapter name
     */
    const ADAPTER_NAME = 'symfony';

    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Provides a method to generate an URL starting from a route name
     *
     * @param string $routeName route name
     *
     * @return string
     */
    public function generateUrl($routeName)
    {
        if ("" == $routeName) {
            return $routeName;
        }

        return $this->router->generate($routeName);
    }
}
