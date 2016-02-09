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

use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;

/**
 * Class PurchasableNameResolverExtension.
 */
final class PurchasableNameResolverExtension extends Twig_Extension
{
    /**
     * @var PurchasableNameResolverInterface
     *
     * Purchasable name resolver
     */
    private $purchasableNameResolver;

    /**
     * Constructor.
     *
     * @param PurchasableNameResolverInterface $purchasableNameResolver Purchasable name resolver
     */
    public function __construct(PurchasableNameResolverInterface $purchasableNameResolver)
    {
        $this->purchasableNameResolver = $purchasableNameResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('purchasable_name', [
                $this->purchasableNameResolver,
                'resolveName',
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
        return 'purchasable_name_resolver_extension';
    }
}
