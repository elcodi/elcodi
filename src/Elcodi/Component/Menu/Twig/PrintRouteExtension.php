<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Menu\Twig;

use Symfony\Component\Routing\Exception\ExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class PrintRouteExtension.
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
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    private $urlGenerator;

    /**
     * Construct method.
     *
     * @param UrlGeneratorInterface $urlGenerator Url Generator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[] An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('generate_url', [$this, 'printUrl']),
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
        if (empty($route)) {
            return '';
        }

        try {
            $url = $this
                ->urlGenerator
                ->generate($route);
        } catch (ExceptionInterface $e) {
            $url = (string) $route;
        }

        return $url;
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
