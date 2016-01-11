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

namespace Elcodi\Component\Product\NameResolver\Interfaces;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Interface PurchasableNameResolverInterface.
 */
interface PurchasableNameResolverInterface
{
    /**
     * @var string
     *
     * Default separator
     */
    const DEFAULT_SEPARATOR = ' - ';

    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace();

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
    );
}
