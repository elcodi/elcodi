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
     * Construct method
     *
     * @param UrlGeneratorInterface $router                         Router
     * @param string                $imageResizeControllerRouteName Image resize controller route name
     * @param string                $imageViewControllerRouteName   Image view controller route name
     */
    public function __construct(
        UrlGeneratorInterface $router,
        $imageResizeControllerRouteName,
        $imageViewControllerRouteName
    )
    {
        $this->router = $router;
        $this->imageResizeControllerRouteName = $imageResizeControllerRouteName;
        $this->imageViewControllerRouteName = $imageViewControllerRouteName;
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
        return $this
            ->router
            ->generate($this->imageResizeControllerRouteName, array(
                'id'     => (int) $imageMedia->getId(),
                'height' => (int) $options['height'],
                'width'  => (int) $options['width'],
                'type'   => (int) $options['type'],
            ), true);
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
        return $this
            ->router
            ->generate($this->imageViewControllerRouteName, array(
                'id' => (int) $imageMedia->getId()
            ), true);
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
