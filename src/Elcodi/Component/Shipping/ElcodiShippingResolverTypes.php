<?php

/*
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

namespace Elcodi\Component\Shipping;

/**
 * Class ElcodiShippingResolverTypes
 */
final class ElcodiShippingResolverTypes
{
    /**
     * @var integer
     *
     * Return always all available carriers
     */
    const CARRIER_RESOLVER_ALL = 'all';

    /**
     * @var integer
     *
     * Return always the highest price carrier
     */
    const CARRIER_RESOLVER_HIGHEST = 'highest';

    /**
     * @var integer
     *
     * Return always the lowest price carrier
     */
    const CARRIER_RESOLVER_LOWEST = 'lowest';
}
