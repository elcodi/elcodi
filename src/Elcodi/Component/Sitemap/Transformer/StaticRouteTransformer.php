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

namespace Elcodi\Component\Sitemap\Transformer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Sitemap\Transformer\Interfaces\SitemapTransformerInterface;

/**
 * Class StaticRouteTransformer.
 */
class StaticRouteTransformer implements SitemapTransformerInterface
{
    /**
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    private $router;

    /**
     * Construct.
     *
     * @param UrlGeneratorInterface $router Router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Get url given an entity.
     *
     * @param mixed       $element  Element
     * @param string|null $language Language
     *
     * @return string url
     */
    public function getLoc($element, $language = null)
    {
        return $this
            ->router
            ->generate($element, [
                '_locale' => $language,
            ], false);
    }

    /**
     * Get last mod.
     *
     * @param mixed  $element  Element
     * @param string $language Language
     *
     * @return string Last mod value
     */
    public function getLastMod($element, $language = null)
    {
        return null;
    }
}
