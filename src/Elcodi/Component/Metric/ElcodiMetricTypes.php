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

namespace Elcodi\Component\Metric;

/**
 * Class ElcodiMetricTypes.
 */
final class ElcodiMetricTypes
{
    /**
     * Metric type beacon unique.
     *
     * This type will be treated as a simple beacon in the metric ecosystem.
     * Useful for getting nb of elements
     *
     * * To get unique values over the time
     */
    const TYPE_BEACON_UNIQUE = 1;

    /**
     * Metric type beacon total.
     *
     * This type will be treated as a simple beacon in the metric ecosystem.
     * Useful for getting nb of elements
     *
     * * To get total values over the time
     */
    const TYPE_BEACON_TOTAL = 2;

    /**
     * Metric type beacon.
     *
     * Both unique and total
     */
    const TYPE_BEACON_ALL = 3;

    /**
     * Metric type accumulated.
     *
     * This type will be treated as an accumulated element in the metric
     * ecosystem
     *
     * This means that the value will be accumulated in a single value over the
     * time. Useful for getting totals
     *
     * * To sum values over the time
     */
    const TYPE_ACCUMULATED = 4;

    /**
     * Metric type distributive.
     *
     * This type will be treated as an distributive element in the metric
     * ecosystem
     *
     * * To get values of type (x) over the time
     */
    const TYPE_DISTRIBUTIVE = 8;
}
