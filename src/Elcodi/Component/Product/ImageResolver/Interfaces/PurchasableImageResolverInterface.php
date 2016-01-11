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

namespace Elcodi\Component\Product\ImageResolver\Interfaces;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Interface PurchasableImageResolverInterface.
 */
interface PurchasableImageResolverInterface
{
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace();

    /**
     * Get valid Image.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImage(PurchasableInterface $purchasable);
}
