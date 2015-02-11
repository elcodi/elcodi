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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Metric\Core\Bucket\Abstracts;

use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;

/**
 * Class AbstractMetricsBucket
 */
abstract class AbstractMetricsBucket
{
    /**
     * Create key given an entry
     *
     * @param string $token Event
     * @param string $event Token
     *
     * @return string key
     */
    protected function generateEntryKey($token, $event)
    {
        return
            $this->normalizeForKey($token).
            '.'.
            $this->normalizeForKey($event);
    }

    /**
     * Normalize string for key format
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
     * Add Metric into Bucket
     *
     * @param EntryInterface $entry Entry
     *
     * @return $this Self Object
     */
    abstract public function add(EntryInterface $entry);

    /**
     * Get Count from bucket given selectors
     *
     * @param string $token Event
     * @param string $event Token
     * @param string $date  Date
     *
     * @return integer Number of hits
     */
    abstract public function get($token, $event, $date);

    /**
     * Get Count from bucket given selectors
     *
     * @param string $event Token
     * @param string $date  Date
     *
     * @return integer Number of hits
     */
    abstract public function getGlobal($event, $date);
}
