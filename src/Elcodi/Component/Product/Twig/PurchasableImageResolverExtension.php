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

namespace Elcodi\Component\Product\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Component\Product\ImageResolver\Interfaces\PurchasableImageResolverInterface;

/**
 * Class ImageResolverExtension.
 */
final class PurchasableImageResolverExtension extends Twig_Extension
{
    /**
     * @var PurchasableImageResolverInterface
     *
     * Purchasable image resolver
     */
    private $purchasableImageResolver;

    /**
     * Construct.
     *
     * @param PurchasableImageResolverInterface $purchasableImageResolver Purchasable image resolver
     */
    public function __construct(PurchasableImageResolverInterface $purchasableImageResolver)
    {
        $this->purchasableImageResolver = $purchasableImageResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('valid_image', [
                $this->purchasableImageResolver,
                'getValidImage',
            ]),
        ];
    }

    /**
     * return extension name.
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'purchasable_image_resolver_extension';
    }
}
