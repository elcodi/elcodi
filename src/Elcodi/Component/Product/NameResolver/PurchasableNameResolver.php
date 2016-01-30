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

namespace Elcodi\Component\Product\NameResolver;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;

/**
 * Class PurchasableNameResolver.
 */
class PurchasableNameResolver implements PurchasableNameResolverInterface
{
    /**
     * @var PurchasableNameResolverInterface[]
     *
     * Name resolvers
     */
    private $nameResolvers = [];

    /**
     * Add a name resolver.
     *
     * @param PurchasableNameResolverInterface $nameResolver Name resolver
     */
    public function addPurchasableNameResolver(PurchasableNameResolverInterface $nameResolver)
    {
        $this->nameResolvers[] = $nameResolver;
    }

    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface';
    }

    /**
     * Given a purchasable, resolve the name.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param string               $separator   Separator
     *
     * @return false|string Name resolved or false if invalid object
     */
    public function resolveName(
        PurchasableInterface $purchasable,
        $separator = self::DEFAULT_SEPARATOR
    ) {
        foreach ($this->nameResolvers as $nameResolver) {
            $nameResolverNamespace = $nameResolver->getPurchasableNamespace();
            if ($purchasable instanceof $nameResolverNamespace) {
                return $nameResolver->resolveName(
                    $purchasable,
                    $separator
                );
            }
        }

        return false;
    }
}
