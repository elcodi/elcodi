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

namespace Elcodi\Component\Metric\Core\Bucket;

use Predis\Client as Predis;
use Predis\CommunicationException;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;
use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;
use Elcodi\Component\Metric\ElcodiMetricTypes;

/**
 * Class RedisMetricsBucket.
 */
class RedisMetricsBucket extends AbstractMetricsBucket
{
    /**
     * @var Predis
     *
     * Redis instance
     */
    private $redis;

    /**
     * Construct.
     *
     * @param Predis $redis Redis
     */
    public function __construct(Predis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Add Metric into Bucket.
     *
     * @param EntryInterface $entry Entry
     *
     * @return $this Self Object
     */
    public function add(EntryInterface $entry)
    {
        $this
            ->addWithFormattedHour($entry, 'Y-m-d')
            ->addWithFormattedHour($entry, 'Y-m-d-H');

        return $this;
    }

    /**
     * Get number of unique beacons given an event and a set of dates.
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return int Number of hits
     */
    public function getBeaconsUnique($token, $event, array $dates)
    {
        $keys = [];

        foreach ($dates as $date) {
            $keys[] = $this->generateEntryKey(
                    $token,
                    $event,
                    $date
                ) . '_unique';
        }

        return (int)
        $this->doRedisQuery(function () use ($keys) {
            $this
                ->redis
                ->pfCount($keys);
        }, 0);
    }

    /**
     * Get the total of beacons given an event and a set of dates.
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return int Number of beacons, given an event and dates
     */
    public function getBeaconsTotal($token, $event, array $dates)
    {
        $total = 0;

        foreach ($dates as $date) {
            $key = $this->generateEntryKey(
                $token,
                $event,
                $date
            );

            $total += $this->doRedisQuery(function () use ($key) {
                $this
                    ->redis
                    ->get($key . '_total');
            }, 0);
        }

        return $total;
    }

    /**
     * Get distributions given an event and a set of dates.
     *
     * @param string $token Event
     * @param string $event Token
     * @param array  $dates Dates
     *
     * @return int Accumulation of event and given dates
     */
    public function getAccumulation($token, $event, array $dates)
    {
        $total = 0;

        foreach ($dates as $date) {
            $key = $this->generateEntryKey(
                $token,
                $event,
                $date
            );

            $total += $this->doRedisQuery(function () use ($key) {
                $this
                    ->redis
                    ->get($key . '_accum');
            }, 0);
        }

        return $total;
    }

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
    public function getDistributions($token, $event, array $dates)
    {
        $distributions = [];

        foreach ($dates as $date) {
            $key = $this->generateEntryKey(
                $token,
                $event,
                $date
            );

            $partials = $this->doRedisQuery(function () use ($key) {
                $this
                    ->redis
                    ->hgetall($key . '_distr');
            }, []);

            foreach ($partials as $key => $value) {
                $distributions[$key] = isset($partialTotals[$key])
                    ? $distributions[$key] + $value
                    : $value;
            }
        }

        arsort($distributions);

        return $distributions;
    }

    /**
     * Add metric given hour formatted.
     *
     * @param EntryInterface $entry          Entry
     * @param string         $dateTimeFormat DateTime format
     *
     * @return $this Self Object
     */
    private function addWithFormattedHour(
        EntryInterface $entry,
        $dateTimeFormat
    ) {
        $entryKey = $this->generateEntryKey(
            $entry->getToken(),
            $entry->getEvent(),
            $entry->getCreatedAt()->format($dateTimeFormat)
        );

        $entryType = $entry->getType();

        /**
         * If the entry must be treated as a beacon.
         */
        if ($entryType & ElcodiMetricTypes::TYPE_BEACON_UNIQUE) {
            $this->addBeaconMetricUnique($entry, $entryKey);
        }

        /**
         * If the entry must be treated as a beacon.
         */
        if ($entryType & ElcodiMetricTypes::TYPE_BEACON_TOTAL) {
            $this->addBeaconMetricTotal($entryKey);
        }

        /**
         * If the entry must be treated as an accumulated metric.
         */
        if ($entryType & ElcodiMetricTypes::TYPE_ACCUMULATED) {
            $this->addAccumulativeEntry($entry, $entryKey);
        }

        /**
         * If the entry must be treated as a distributed metric.
         */
        if ($entryType & ElcodiMetricTypes::TYPE_DISTRIBUTIVE) {
            $this->addDistributedEntry($entry, $entryKey);
        }

        return $this;
    }

    /**
     * Add beacon unique nb given the key entry.
     *
     * @param EntryInterface $entry    Entry
     * @param string         $entryKey Key entry
     *
     * @return $this Self Object
     */
    private function addBeaconMetricUnique(
        EntryInterface $entry,
        $entryKey
    ) {
        $this->doRedisQuery(function () use ($entry, $entryKey) {
            $this
                ->redis
                ->pfAdd(
                    $entryKey . '_unique',
                    $entry->getValue()
                );
        });

        return $this;
    }

    /**
     * Add beacon total nb given the key entry.
     *
     * @param string $entryKey Key entry
     *
     * @return $this Self Object
     */
    private function addBeaconMetricTotal($entryKey)
    {
        $this->doRedisQuery(function () use ($entryKey) {
            $this
                ->redis
                ->incr($entryKey . '_total');
        });

        return $this;
    }

    /**
     * Add accumulative metric.
     *
     * @param EntryInterface $entry    Entry
     * @param string         $entryKey Key entry
     *
     * @return $this Self Object
     */
    private function addAccumulativeEntry(
        EntryInterface $entry,
        $entryKey
    ) {
        $this->doRedisQuery(function () use ($entry, $entryKey) {
            $this
                ->redis
                ->incrby(
                    $entryKey . '_accum',
                    (int) $entry->getValue()
                );
        });

        return $this;
    }

    /**
     * Add distributed metric.
     *
     * @param EntryInterface $entry    Entry
     * @param string         $entryKey Key entry
     *
     * @return $this Self Object
     */
    private function addDistributedEntry(
        EntryInterface $entry,
        $entryKey
    ) {
        $this->doRedisQuery(function () use ($entry, $entryKey) {
            $this
                ->redis
                ->hincrby(
                    $entryKey . '_distr',
                    $entry->getValue(),
                    1
                );
        });

        return $this;
    }

    /**
     * Try a redis query and return it's result.
     *
     * If the call catches a connection Exception, then returns the provided
     * default value (false by default)
     *
     * @param callable $callable     Callable function
     * @param mixed    $defaultValue Default value to return if exception
     *
     * @return mixed Result of the callable or $defaultValue if connection exception
     */
    private function doRedisQuery(callable $callable, $defaultValue = false)
    {
        try {
            $result = $callable();
        } catch (CommunicationException $communicationException) {
            $result = $defaultValue;
        }

        return $result;
    }
}
