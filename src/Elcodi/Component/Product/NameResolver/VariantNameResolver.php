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

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;

/**
 * Class VariantNameResolver.
 */
class VariantNameResolver implements PurchasableNameResolverInterface
{
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Product\Entity\Interfaces\VariantInterface';
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
        $separator = self::DEFAULT_SEPARATOR
    ) {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }

        if (!is_null($purchasable->getName())) {
            return $purchasable->getName();
        }

        /**
         * @var $purchasable VariantInterface
         */
        $variantName = $purchasable
            ->getProduct()
            ->getName();

        foreach ($purchasable->getOptions() as $option) {
            /**
             * @var ValueInterface $option
             */
            $variantName .= $separator .
                $option->getAttribute()->getName() .
                ' ' .
                $option->getValue();
        }

        return $variantName;
    }
}
