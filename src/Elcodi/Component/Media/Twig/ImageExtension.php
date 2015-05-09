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

namespace Elcodi\Component\Media\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Class ImageExtension
 */
class ImageExtension extends Twig_Extension
{
    /**
     * @var UrlGeneratorInterface
     *
     * Router
     */
    protected $router;

    /**
     * @var string
     *
     * Resize route name
     */
    protected $imageResizeControllerRouteName;

    /**
     * @var string
     *
     * View route name
     */
    protected $imageViewControllerRouteName;

    /**
     * @var string
     *
     * Host part of the generated URL.
     * Useful when working with CDNs, where
     * you might want to map, for instance,
     * http://www.elcodi.com/image/1 to
     * http://cdn.elcodi.com/image/1
     */
    protected $generatedRouteHost;

    /**
     * @var RequestContext
     *
     * Original router context
     */
    protected $originalContext;

    /**
     * @var RequestContext
     *
     * Modified router context
     */
    protected $modifiedContext;

    /**
     * Construct method
     *
     * @param UrlGeneratorInterface $router                         Router
     * @param string                $imageResizeControllerRouteName Image resize controller route name
     * @param string                $imageViewControllerRouteName   Image view controller route name
     * @param string                $generatedRouteHost             Host part of the URL to be overridden, if present
     */
    public function __construct(
        UrlGeneratorInterface $router,
        $imageResizeControllerRouteName,
        $imageViewControllerRouteName,
        $generatedRouteHost = ''

    ) {
        $this->router = $router;
        $this->imageResizeControllerRouteName = $imageResizeControllerRouteName;
        $this->imageViewControllerRouteName = $imageViewControllerRouteName;
        $this->generatedRouteHost = $generatedRouteHost;

        /**
         * Routing context will change when a hostname is
         * forced into the route generation.
         */
        $this->originalContext = $this
            ->router
            ->getContext();

        $this->modifiedContext = clone($this->originalContext);
    }

    /**
     * Return all filters
     *
     * @return Twig_SimpleFilter[] Filters created
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('resize', [$this, 'resize']),
            new Twig_SimpleFilter('viewImage', [$this, 'viewImage']),
        ];
    }

    /**
     * Return route of image with desired resize
     *
     * @param ImageInterface $imageMedia Imagemedia element
     * @param Array          $options    Options
     *
     * @return string image route
     */
    public function resize(ImageInterface $imageMedia, $options)
    {
        $routeReferenceType = $this->prepareRouterContext();

        $generatedRoute = $this
            ->router
            ->generate($this->imageResizeControllerRouteName, [
                'id'      => (int) $imageMedia->getId(),
                'height'  => (int) $options['height'],
                'width'   => (int) $options['width'],
                'type'    => (int) $options['type'],
                '_format' => $imageMedia->getExtension(),
            ], $routeReferenceType);

        $this->fixRouterContext();

        return $generatedRoute;
    }

    /**
     * Return route of image
     *
     * @param ImageInterface $imageMedia Imagemedia element
     *
     * @return string image route
     */
    public function viewImage(ImageInterface $imageMedia)
    {
        $routeReferenceType = $this->prepareRouterContext();

        $generatedRoute = $this
            ->router
            ->generate($this->imageViewControllerRouteName, [
                'id'      => (int) $imageMedia->getId(),
                '_format' => $imageMedia->getExtension(),
            ], $routeReferenceType);

        $this->fixRouterContext();

        return $generatedRoute;
    }

    /**
     * Prepares the Host part of a image resize URL
     *
     * @return mixed Route reference type
     */
    protected function prepareRouterContext()
    {
        if ($this->generatedRouteHost) {
            $this
                ->router
                ->setContext($this->modifiedContext);

            /**
             * When a Host is set for the image route,
             * we need to change the route context URL
             */
            $this
                ->router
                ->getContext()
                ->setHost($this->generatedRouteHost);

            $routeReferenceType = UrlGeneratorInterface::ABSOLUTE_URL;
        } else {
            $routeReferenceType = UrlGeneratorInterface::ABSOLUTE_PATH;
        }

        return $routeReferenceType;
    }

    /**
     * Fixes a router Context back after changing the "Host" URL
     *
     * @return $this Self object
     */
    public function fixRouterContext()
    {
        if ($this->generatedRouteHost) {
            $this
                ->router
                ->setContext($this->originalContext);
        }

        return $this;
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'image_extension';
    }
}
