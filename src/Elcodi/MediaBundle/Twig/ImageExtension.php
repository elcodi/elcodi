<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;

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
    private $router;

    /**
     * @var string
     *
     * Upload route name
     */
    protected $imageResizeControllerRouteName;

    /**
     * Construct method
     *
     * @param UrlGeneratorInterface $router                         Router
     * @param string                $imageResizeControllerRouteName Image resize controller route name
     */
    public function __construct(UrlGeneratorInterface $router, $imageResizeControllerRouteName)
    {
        $this->router = $router;
        $this->imageResizeControllerRouteName = $imageResizeControllerRouteName;
    }

    /**
     * Return all filters
     *
     * @return array Filters created
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('resize', array($this, 'resize')),
        );
    }

    /**
     * Return route of image
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
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'image_extension';
    }
}
