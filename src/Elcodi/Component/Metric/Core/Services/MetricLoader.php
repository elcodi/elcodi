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

namespace Elcodi\Component\Metric\Core\Services;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;
use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;
use Elcodi\Component\Metric\Core\Repository\EntryRepository;

/**
 * Class MetricLoader.
 */
class MetricLoader
{
    /**
     * @var AbstractMetricsBucket
     *
     * Metrics bucket
     */
    private $metricsBucket;

    /**
     * @var EntryRepository
     *
     * Metric entry repository
     */
    private $entryRepository;

    /**
     * Construct.
     *
     * @param AbstractMetricsBucket $metricsBucket   Metrics bucket
     * @param EntryRepository       $entryRepository Metric entry repository
     */
    public function __construct(
        AbstractMetricsBucket $metricsBucket,
        EntryRepository $entryRepository
    ) {
        $this->metricsBucket = $metricsBucket;
        $this->entryRepository = $entryRepository;
    }

    /**
     * Load metrics from last X days and cache them.
     *
     * @param int $days Number of days you want to load and cache
     *
     * @return EntryInterface[] Array of loaded entries
     */
    public function loadEntriesFromLastDays($days)
    {
        $entries = $this
            ->entryRepository
            ->getEntriesFromLastDays($days);

        foreach ($entries as $entry) {
            $this
                ->metricsBucket
                ->add($entry);
        }

        return $entries;
    }
}
