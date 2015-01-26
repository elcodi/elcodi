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

namespace Elcodi\Component\Media\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
     * @var boolean
     *
     * Enable domain sharding
     */
    protected $imageDomainShardingEnabled;

    /**
     * @var boolean
     *
     * Generate absolute or relative path in URLs
     */
    protected $generateAbsolutePath;

    /**
     * @var array
     *
     * Base URLs for the resource origin
     */
    protected $imageDomainShardingBaseUrls;

    /**
     * Construct method
     *
     * @param UrlGeneratorInterface $router                         Router
     * @param string                $imageResizeControllerRouteName Image resize controller route name
     * @param string                $imageViewControllerRouteName   Image view controller route name
     * @param boolean               $imageDomainShardingEnabled     If we are using domain sharding or not
     * @param array                 $imageDomainShardingBaseUrls    Base urls to use in hostnames
     */
    public function __construct(
        UrlGeneratorInterface $router,
        $imageResizeControllerRouteName,
        $imageViewControllerRouteName,
        $imageDomainShardingEnabled,
        $imageDomainShardingBaseUrls
    )
    {
        $this->router = $router;
        $this->imageResizeControllerRouteName = $imageResizeControllerRouteName;
        $this->imageViewControllerRouteName = $imageViewControllerRouteName;

        $this->imageDomainShardingEnabled = $imageDomainShardingEnabled;

        /*
         * If domain sharding is enabled, we cannot use
         * absolute URLs, we will manually generate them
         * as base_url + route_path
         */
        $this->generateAbsolutePath = !$imageDomainShardingEnabled;
        $this->imageDomainShardingBaseUrls = $imageDomainShardingBaseUrls;
    }

    /**
     * Return all filters
     *
     * @return Twig_SimpleFilter[] Filters created
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('resize', array($this, 'resize')),
            new Twig_SimpleFilter('viewImage', array($this, 'viewImage')),
        );
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
        $generatedRoute = $this
            ->router
            ->generate($this->imageResizeControllerRouteName, array(
                'id'      => (int) $imageMedia->getId(),
                'height'  => (int) $options['height'],
                'width'   => (int) $options['width'],
                'type'    => (int) $options['type'],
                '_format' => $imageMedia->getExtension(),
            ), $this->generateAbsolutePath);

        /*
         * Returning generated URL, with or without absolute path
         */

        return $this->randomizeBaseUrls($generatedRoute);
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
        $generatedRoute = $this
            ->router
            ->generate($this->imageViewControllerRouteName, array(
                'id'      => (int) $imageMedia->getId(),
                '_format' => $imageMedia->getExtension(),
            ), $this->generateAbsolutePath);

        return $this->randomizeBaseUrls($generatedRoute);
    }

    /**
     * Rotates an array of configured origin servers
     *
     * This is useful when working with reverse proxies or CDN,
     * where using different hostnames referring to the same origin
     * in URLs can optimize browser load times by parallelizing resource
     * download (domain sharding)
     *
     * @link http://www.stevesouders.com/blog/2009/05/12/sharding-dominant-domains/
     *
     * @return string
     */
    protected function randomizeBaseUrls($path)
    {
        if ($this->generateAbsolutePath) return $path;

        $hostNames = $this->imageDomainShardingBaseUrls;
        /*
         * Retrieve a pseudo random number between 1 and
         * the number of origin base url
         */
        $random = substr(mt_rand(), 0, 1) % count($hostNames);
        $hostName = $hostNames[$random];

        return '//'.$hostName.$path;
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
