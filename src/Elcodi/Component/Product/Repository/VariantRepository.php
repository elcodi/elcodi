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

namespace Elcodi\Component\Product\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class VariantRepository.
 */
class VariantRepository extends EntityRepository
{
    /**
     * Given a Product and an array of integer representing the IDs of a Value Entity,
     * returns the Variant that is associated with the options matching the IDs, if any.
     *
     * @param ProductInterface $product            to compare Variants from
     * @param array            $optionsSearchedIds array containing IDs of the options to match
     *
     * @return VariantInterface|null Variant if found, or null if not
     */
    public function findByOptionIds(ProductInterface $product, array $optionsSearchedIds = [])
    {
        sort($optionsSearchedIds);

        foreach ($product->getVariants() as $variant) {

            /**
             * @var VariantInterface $variant
             */
            $optionsConfiguredIds = array_map(
                function (ValueInterface $option) {
                    return $option->getId();
                },
                $variant->getOptions()->toArray()
            );

            sort($optionsConfiguredIds);

            if ($optionsSearchedIds == $optionsConfiguredIds) {
                /**
                 * Options match, we found the product Variant.
                 */

                return $variant;
            }
        }

        /**
         * No match, probable option misconfiguration in Variants.
         */

        return null;
    }
}
