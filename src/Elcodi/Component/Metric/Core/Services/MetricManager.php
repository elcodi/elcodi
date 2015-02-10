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

namespace Elcodi\Component\Metric\Core\Services;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;
use Elcodi\Component\Metric\Core\Factory\EntryFactory;

/**
 * Class MetricManager
 */
class MetricManager
{
    /**
     * @var AbstractMetricsBucket
     *
     * Metrics bucket
     */
    protected $metricsBucket;

    /**
     * @var EntryFactory
     *
     * Entry factory
     */
    protected $entryFactory;

    /**
     * @var ObjectManager
     *
     * Entry object manager
     */
    protected $entryObjectManager;

    /**
     * Construct
     *
     * @param AbstractMetricsBucket $metricsBucket Metrics bucket
     */
    public function __construct(
        AbstractMetricsBucket $metricsBucket,
        EntryFactory $entryFactory,
        ObjectManager $entryObjectManager
    )
    {
        $this->metricsBucket = $metricsBucket;
        $this->entryFactory = $entryFactory;
        $this->entryObjectManager = $entryObjectManager;
    }

    /**
     * Adds a new entry into database and into metrics bucket
     *
     * @param string $token   Event
     * @param string $event   Token
     * @param array  $context Context
     *
     * @return $this Self Object
     */
    public function addEntry($token, $event, array $context = [])
    {
        $now = new DateTime();
        $context = json_encode($context);
        $entry = $this
            ->entryFactory
            ->create(
                $token,
                $event,
                $context,
                $now
            );

        $this->entryObjectManager->persist($entry);
        $this->entryObjectManager->flush($entry);

        $this
            ->metricsBucket
            ->add($entry);

        return $this;
    }
}
