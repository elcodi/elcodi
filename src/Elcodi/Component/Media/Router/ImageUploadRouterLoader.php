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
 */

namespace Elcodi\Component\Media\Router;

use RuntimeException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class ImageUploadRouterLoader
 */
class ImageUploadRouterLoader implements LoaderInterface
{
    /**
     * @var string
     *
     * Upload route name
     */
    protected $imageUploadControllerRouteName;

    /**
     * @var string
     *
     * Upload controller route
     */
    protected $imageUploadControllerRoute;

    /**
     * @var boolean
     *
     * Route is loaded
     */
    protected $loaded = false;

    /**
     * Construct method
     *
     * @param string $imageUploadControllerRouteName Image upload controller route name
     * @param string $imageUploadControllerRoute     Image upload controller route
     */
    public function __construct(
        $imageUploadControllerRouteName,
        $imageUploadControllerRoute
    )
    {
        $this->imageUploadControllerRouteName = $imageUploadControllerRouteName;
        $this->imageUploadControllerRoute = $imageUploadControllerRoute;
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
        $routes->add($this->imageUploadControllerRouteName, new Route($this->imageUploadControllerRoute, array(
            '_controller' => 'elcodi.core.media.controller.image_upload:uploadAction',
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
        return 'elcodi_image_upload' === $type;
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
