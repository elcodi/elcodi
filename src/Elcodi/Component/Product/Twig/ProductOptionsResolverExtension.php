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
use Twig_SimpleFunction;

use Elcodi\Component\Product\Services\ProductOptionsResolver;

/**
 * Class ProductOptionsResolverExtension.
 */
final class ProductOptionsResolverExtension extends Twig_Extension
{
    /**
     * @var ProductOptionsResolver
     *
     * Product options resolver
     */
    private $productOptionsResolver;

    /**
     * Construct.
     *
     * @param ProductOptionsResolver $productOptionsResolver Product options resolver
     */
    public function __construct(ProductOptionsResolver $productOptionsResolver)
    {
        $this->productOptionsResolver = $productOptionsResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFunction[] Functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('available_options', [
                $this->productOptionsResolver,
                'getAvailableOptions',
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
        return 'product_options_resolver_extension';
    }
}
