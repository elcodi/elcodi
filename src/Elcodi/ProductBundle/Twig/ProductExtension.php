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

namespace Elcodi\ProductBundle\Twig;

use Doctrine\Common\Collections\ArrayCollection;
use Twig_Extension;

use Elcodi\AttributeBundle\Entity\Interfaces\AttributeInterface;
use Elcodi\AttributeBundle\Entity\Interfaces\ValueInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\PurchasableInterface;
use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;

/**
 * Product extension for twig
 */
class ProductExtension extends Twig_Extension
{
    /**
     * Returns defined twig functions
     *
     * @return array|void
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('available_options', array($this, 'getAvailableOptions'))
        ];
    }

    /**
     * Returns defined twig functions
     *
     * @return array|void
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('purchasable_name', array($this, 'getPurchasableName'))
        ];
    }

    /**
     * Returns a homan readable name for a purchasable, whether Product or Variant
     *
     * @param PurchasableInterface $purchasable Purchasable to get name from
     * @param string               $separator   Separator string for product variant options
     *
     * @return string
     */
    public function getPurchasableName(PurchasableInterface $purchasable, $separator = ' - ')
    {
        $productName = "";

        if ($purchasable instanceof ProductInterface) {
            /**
             * @var ProductInterface $purchasable
             */
            $productName = $purchasable->getName();

        } else {
            /**
             * @var VariantInterface $purchasable
             */
            $productName = $purchasable->getProduct()->getName();

            foreach ($purchasable->getOptions() as $option) {
                /**
                 * @var ValueInterface $option
                 */
                $productName .= $separator .
                    $option->getAttribute()->getName() .
                    ' ' .
                    $option->getName();
            }
        }

        return $productName;
    }

    /**
     * Returns an array of unique available options for a Product
     *
     * Returned Options belong to Variants available for purchase
     *
     * @param AttributeInterface $attribute
     *
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     *
     * @return ArrayCollection
     */
    public function getAvailableOptions(ProductInterface $product, AttributeInterface $attribute)
    {
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
                    !$availableOptions->contains($option)) {

                    $availableOptions->add($option);
                }
            }
        }

        return $availableOptions;
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'product_extension';
    }
}
