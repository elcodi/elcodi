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

namespace Elcodi\Component\Product\ImageResolver;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\ImageResolver\Abstracts\AbstractImageResolverWithImageResolver;
use Elcodi\Component\Product\ImageResolver\Interfaces\PurchasableImageResolverInterface;

/**
 * Class PackImageResolver.
 */
class PackImageResolver extends AbstractImageResolverWithImageResolver implements PurchasableImageResolverInterface
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
     * Get valid Image.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImage(PurchasableInterface $purchasable)
    {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }

        /**
         * @var PackInterface $purchasable
         */
        $packImage = $this
            ->imageResolver
            ->resolveImage($purchasable);

        if ($packImage instanceof ImageInterface) {
            return $packImage;
        }

        foreach ($purchasable->getPurchasables() as $purchasable) {
            $purchasableImage = $this->getValidImageByCollection($purchasable);
            if ($purchasableImage instanceof ImageInterface) {
                return $purchasableImage;
            }
        }

        return false;
    }
}
