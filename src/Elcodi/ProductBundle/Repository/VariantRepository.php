<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\ProductBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Elcodi\AttributeBundle\Entity\Interfaces\ValueInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;

/**
 * Class VariantRepository
 */
class VariantRepository extends EntityRepository
{
    /**
     * Given a Product and an array of integer representing the IDs of a Value Entitiy,
     * returns the Variant that is associated with the options matching the IDs, if any
     *
     * @param ProductInterface $product to compare Variants from
     * @param $optionsSearchedIds array containng IDs of the options to match
     *
     * @return VariantInterface|null
     */
    public function findByOptionIds(ProductInterface $product, $optionsSearchedIds)
    {
        $optionsConfiguredIds = [];

        sort($optionsSearchedIds);

        foreach ($product->getVariants() as $variant) {

            /** @var VariantInterface $variant */
            $optionsConfiguredIds = array_map(function ($option) {

                /** @var ValueInterface $option */

                return $option->getId();

            }, $variant->getOptions()->toArray());

            sort($optionsConfiguredIds);

            if ($optionsSearchedIds == $optionsConfiguredIds) {
                /**
                 * Options match, we found the product Variant
                 */

                return $variant;
            }
        }

        /**
         * No match, probable option misconfiguration in Variants
         */

        return null;
    }
}
