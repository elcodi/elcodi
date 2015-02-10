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
    protected $metricBucket;

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
            new Twig_SimpleFunction('metric_count', array($this, 'getMetricCount')),
            new Twig_SimpleFunction('metric_global_count', array($this, 'getGlobalMetricCount')),
        ];
    }

    /**
     * Return metric counter
     *
     * @param string $token Event
     * @param string $event Token
     * @param string $date  Date
     *
     * @return string Html content
     */
    public function getMetricCount(
        $token,
        $event,
        $date
    )
    {
        return (int) $this
            ->metricBucket
            ->get($token, $event, $date);
    }

    /**
     * Returns global metric counter
     *
     * @param string $event Token
     * @param string $date  Date
     *
     * @return string Html content
     */
    public function getGlobalMetricCount(
        $event,
        $date
    )
    {
        return (int) $this
            ->metricBucket
            ->getGlobal($event, $date);
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
