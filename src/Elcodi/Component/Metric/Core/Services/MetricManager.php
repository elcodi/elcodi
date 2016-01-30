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

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;
use Elcodi\Component\Metric\Core\Factory\EntryFactory;

/**
 * Class MetricManager.
 */
class MetricManager
{
    /**
     * @var AbstractMetricsBucket
     *
     * Metrics bucket
     */
    private $metricsBucket;

    /**
     * @var EntryFactory
     *
     * Entry factory
     */
    private $entryFactory;

    /**
     * @var ObjectManager
     *
     * Entry object manager
     */
    private $entryObjectManager;

    /**
     * Construct.
     *
     * @param AbstractMetricsBucket $metricsBucket      Metrics bucket
     * @param EntryFactory          $entryFactory       Entry Factory
     * @param ObjectManager         $entryObjectManager Entry Object Manager
     */
    public function __construct(
        AbstractMetricsBucket $metricsBucket,
        EntryFactory $entryFactory,
        ObjectManager $entryObjectManager
    ) {
        $this->metricsBucket = $metricsBucket;
        $this->entryFactory = $entryFactory;
        $this->entryObjectManager = $entryObjectManager;
    }

    /**
     * Adds a new entry into database and into metrics bucket.
     *
     * @param string   $token    Event
     * @param string   $event    Token
     * @param string   $uniqueId Unique id
     * @param int      $type     Type
     * @param DateTime $dateTime DateTime
     *
     * @return $this Self Object
     */
    public function addEntry(
        $token,
        $event,
        $uniqueId,
        $type,
        DateTime $dateTime
    ) {
        $entry = $this
            ->entryFactory
            ->create(
                $token,
                $event,
                $uniqueId,
                $type,
                $dateTime
            );

        $this->entryObjectManager->persist($entry);
        $this->entryObjectManager->flush($entry);

        $this
            ->metricsBucket
            ->add($entry);

        return $this;
    }
}
