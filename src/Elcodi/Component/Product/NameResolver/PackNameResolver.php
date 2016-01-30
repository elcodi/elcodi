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

use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;

/**
 * Class PackNameResolver.
 */
class PackNameResolver implements PurchasableNameResolverInterface
{
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Product\Entity\Interfaces\PackInterface';
    }

    /**
     * Given a purchasable, resolve the name.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param string               $separator   Separator
     *
     * @return string Name resolved
     */
    public function resolveName(
        PurchasableInterface $purchasable,
        $separator = null
    ) {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }

        /**
         * @var $purchasable PackInterface
         */
        return $purchasable->getName();
    }
}
