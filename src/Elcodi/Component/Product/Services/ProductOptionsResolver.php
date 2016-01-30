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

namespace Elcodi\Component\Product\Services;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class ProductOptionsResolver.
 */
class ProductOptionsResolver
{
    /**
     * Returns an array of unique available options for a Product.
     *
     * Returned Options belong to Variants available for purchase
     *
     * @param ProductInterface   $product   Product
     * @param AttributeInterface $attribute Attribute
     *
     * @return ArrayCollection
     */
    public function getAvailableOptions(
        ProductInterface $product,
        AttributeInterface $attribute
    ) {
        $availableOptions = new ArrayCollection();

        foreach ($product->getVariants() as $variant) {

            /**
             * @var VariantInterface $variant
             */
            if (!$variant->isEnabled() || $variant->getStock() <= 0) {
                continue;
            }

            foreach ($variant->getOptions() as $option) {
                /**
                 * @var ValueInterface $option
                 */
                if ($option->getAttribute() == $attribute &&
                    !$availableOptions->contains($option)
                ) {
                    $availableOptions->add($option);
                }
            }
        }

        return $availableOptions;
    }
}
