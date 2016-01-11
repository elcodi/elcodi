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

namespace Elcodi\Component\Metric\Core\Bucket\Abstracts;

use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;

/**
 * Class AbstractMetricsBucket.
 */
abstract class AbstractMetricsBucket
{
    /**
     * Create key given an entry.
     *
     * @param string $token Event
     * @param string $event Token
     * @param string $date  Date
     *
     * @return string key
     */
    protected function generateEntryKey($token, $event, $date)
    {
        return
            $this->normalizeForKey($token) .
            '.' .
            $this->normalizeForKey($event) .
            '.' .
            $this->normalizeForKey($date);
    }

    /**
     * Normalize string for key format.
     *
     * @param string $string String
     *
     * @return string String normalized
     */
    public function normalizeForKey($string)
    {
        return str_replace('.', '_', $string);
    }

    /**
     * Add Metric into Bucket.
     *
     * @param EntryInterface $entry Entry
     *
     * @return $this Self Object
     */
    abstract public function add(EntryInterface $entry);

    /**
     * Get number of unique beacons given an event and a set of dates.
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return int Number of hits
     */
    abstract public function getBeaconsUnique($token, $event, array $dates);

    /**
     * Get the total of beacons given an event and a set of dates.
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return int Number of beacons, given an event and dates
     */
    abstract public function getBeaconsTotal($token, $event, array $dates);

    /**
     * Get distributions given an event and a set of dates.
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return int Accumulation of event and given dates
     */
    abstract public function getAccumulation($token, $event, array $dates);

    /**
     * Get distributions given an event and a set of dates.
     *
     * [
     *      "value3": 24,
     *      "value7": 13,
     *      "value8": 9,
     * ]
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return array Distribution with totals
     */
    abstract public function getDistributions($token, $event, array $dates);
}
