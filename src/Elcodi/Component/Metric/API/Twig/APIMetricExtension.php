<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Metric\API\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;

/**
 * Class APIMetricExtension
 */
class APIMetricExtension extends Twig_Extension
{
    /**
     * @var AbstractMetricsBucket
     *
     * Metric bucket
     */
    private $metricBucket;

    /**
     * Construct
     *
     * @param AbstractMetricsBucket $metricBucket Metric bucket
     */
    public function __construct(AbstractMetricsBucket $metricBucket)
    {
        $this->metricBucket = $metricBucket;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[] An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('metric_beacon_unique', [$this, 'getBeaconsUnique']),
            new Twig_SimpleFunction('metric_beacon_total', [$this, 'getBeaconsTotal']),
            new Twig_SimpleFunction('metric_accumulation', [$this, 'getAccumulation']),
            new Twig_SimpleFunction('metric_distributions', [$this, 'getDistributions']),
        ];
    }

    /**
     * Return metric beacons unique counter
     *
     * @param string   $token Event
     * @param string   $event Token
     * @param string[] $dates Dates
     *
     * @return integer Beacons unique
     */
    public function getBeaconsUnique(
        $token,
        $event,
        $dates
    ) {
        return (int) $this
            ->metricBucket
            ->getBeaconsUnique((string) $token, (string) $event, $dates);
    }

    /**
     * Return metric unique counter
     *
     * @param string   $token Event
     * @param string   $event Token
     * @param string[] $dates Dates
     *
     * @return integer Beacons total
     */
    public function getBeaconsTotal(
        $token,
        $event,
        $dates
    ) {
        return (int) $this
            ->metricBucket
            ->getBeaconsTotal((string) $token, (string) $event, $dates);
    }

    /**
     * Return metric accumulation counter
     *
     * @param string   $token Event
     * @param string   $event Token
     * @param string[] $dates Dates
     *
     * @return integer Accumulation
     */
    public function getAccumulation(
        $token,
        $event,
        $dates
    ) {
        return $this
            ->metricBucket
            ->getAccumulation((string) $token, (string) $event, $dates);
    }

    /**
     * Return metric distributions
     *
     * @param string   $token Event
     * @param string   $event Token
     * @param string[] $dates Dates
     *
     * @return array Distribution values
     */
    public function getDistributions(
        $token,
        $event,
        $dates
    ) {
        return (int) $this
            ->metricBucket
            ->getDistributions((string) $token, (string) $event, $dates);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'api_metric_extension';
    }
}
