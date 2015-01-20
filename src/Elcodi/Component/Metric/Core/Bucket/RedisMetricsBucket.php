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

namespace Elcodi\Component\Metric\Core\Bucket;

use Redis;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;
use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;

/**
 * Class RedisMetricsBucket
 */
class RedisMetricsBucket extends AbstractMetricsBucket
{
    /**
     * @var Redis
     *
     * Redis instance
     */
    protected $redis;

    /**
     * Construct
     *
     * @param Redis $redis Redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Add Metric into Bucket
     *
     * @param EntryInterface $entry Entry
     *
     * @return $this Self Object
     */
    public function add(EntryInterface $entry)
    {
        $createdAt = $entry->getCreatedAt();
        $globalEntryKey = $entry->getEvent();
        $entryKey = $this->generateEntryKey(
            $entry->getToken(),
            $entry->getEvent()
        );

        $this
            ->incrementPointerByKey($createdAt->format('Y.m.d.H'), $globalEntryKey)
            ->incrementPointerByKey($createdAt->format('Y.m.d.H'), $entryKey)
            ->incrementPointerByKey($createdAt->format('Y.m.d'), $globalEntryKey)
            ->incrementPointerByKey($createdAt->format('Y.m.d'), $entryKey)
            ->incrementPointerByKey($createdAt->format('Y.m'), $globalEntryKey)
            ->incrementPointerByKey($createdAt->format('Y.m'), $entryKey);
    }

    /**
     * Get Count from bucket given selectors
     *
     * @param string $token Event
     * @param string $event Token
     * @param string $date  Date
     *
     * @return integer Number of hits
     */
    public function get($token, $event, $date)
    {
        $entryKey = $this->generateEntryKey(
            $token,
            $event
        );

        return $this
            ->redis
            ->hGet(
                $date,
                $entryKey
            );
    }

    /**
     * Get Count from bucket given selectors
     *
     * @param string $event Token
     * @param string $date  Date
     *
     * @return integer Number of hits
     */
    public function getGlobal($event, $date)
    {
        return $this
            ->redis
            ->hGet(
                $date,
                $event
            );
    }

    /**
     * Increment the pointer by one with given key
     *
     * @param string $key     Key
     * @param string $hashKey Hash Key
     *
     * @return $this Self Object
     */
    protected function incrementPointerByKey(
        $key,
        $hashKey
    )
    {
        $this
            ->redis
            ->hIncrBy(
                $key,
                $hashKey,
                1
            );

        return $this;
    }
}
