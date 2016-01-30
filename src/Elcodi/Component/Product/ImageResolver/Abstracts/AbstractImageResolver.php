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

namespace Elcodi\Component\Product\ImageResolver\Abstracts;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\ImageResolver\Interfaces\PurchasableImageResolverInterface;

/**
 * Class AbstractImageResolver.
 */
abstract class AbstractImageResolver
{
    /**
     * @var PurchasableImageResolverInterface[]
     *
     * Image resolvers
     */
    private $purchasableImageResolvers = [];

    /**
     * Add an image resolver.
     *
     * @param PurchasableImageResolverInterface $purchasableImageResolver Purchasable Image resolver
     */
    public function addPurchasableImageResolver(PurchasableImageResolverInterface $purchasableImageResolver)
    {
        $this->purchasableImageResolvers[] = $purchasableImageResolver;
    }

    /**
     * Get valid Image.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImageByCollection(PurchasableInterface $purchasable)
    {
        foreach ($this->purchasableImageResolvers as $purchasableImageResolver) {
            $purchasableImageResolverNamespace = $purchasableImageResolver->getPurchasableNamespace();
            if ($purchasable instanceof $purchasableImageResolverNamespace) {
                return $purchasableImageResolver->getValidImage($purchasable);
            }
        }

        return false;
    }
}
