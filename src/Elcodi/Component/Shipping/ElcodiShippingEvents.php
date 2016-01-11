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

namespace Elcodi\Component\Shipping;

/**
 * Class ElcodiShippingEvents.
 */
final class ElcodiShippingEvents
{
    /**
     * This event is dispatched when all shipping possibilities are required.
     *
     * event.name : shipping.collect
     * event.class : ShippingCollectionEvent
     */
    const SHIPPING_COLLECT = 'shipping.collect';
}
