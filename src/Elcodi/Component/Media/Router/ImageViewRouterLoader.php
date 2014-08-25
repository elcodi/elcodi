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

namespace Elcodi\Component\Media\Router;

use RuntimeException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class ImageViewRouterLoader
 */
class ImageViewRouterLoader implements LoaderInterface
{
    /**
     * @var string
     *
     * Upload route name
     */
    protected $imageViewControllerRouteName;

    /**
     * @var string
     *
     * Upload controller route
     */
    protected $imageViewControllerRoute;

    /**
     * @var boolean
     *
     * Route is loaded
     */
    protected $loaded = false;

    /**
     * Construct method
     *
     * @param string $imageViewControllerRouteName Image view controller route name
     * @param string $imageViewControllerRoute     Image view controller route
     */
    public function __construct(
        $imageViewControllerRouteName,
        $imageViewControllerRoute
    )
    {
        $this->imageViewControllerRouteName = $imageViewControllerRouteName;
        $this->imageViewControllerRoute = $imageViewControllerRoute;
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

        $routes->add($this->imageViewControllerRouteName, new Route($this->imageViewControllerRoute, array(
            '_controller' => 'elcodi.core.media.controller.image_resize:resizeAction',
            'height' => 0,
            'width'  => 0,
            'type'   => ElcodiMediaImageResizeTypes::NO_RESIZE,
        )));

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
        return 'elcodi_image_view' === $type;
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
