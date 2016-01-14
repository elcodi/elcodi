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

namespace Elcodi\Component\Metric\API\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Metric\Core\Bucket\Abstracts\AbstractMetricsBucket;

/**
 * Class APIMetricExtension.
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
     * Construct.
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
            new Twig_SimpleFunction('metric_beacon_unique', function ($token, $event, $dates) {

                return $this
                    ->metricBucket
                    ->getBeaconsUnique($token, $event, $dates);
            }),
            new Twig_SimpleFunction('metric_beacon_total', function ($token, $event, $dates) {

                return $this
                    ->metricBucket
                    ->getBeaconsTotal($token, $event, $dates);
            }),
            new Twig_SimpleFunction('metric_accumulation', function ($token, $event, $dates) {

                return $this
                    ->metricBucket
                    ->getAccumulation($token, $event, $dates);
            }),
            new Twig_SimpleFunction('metric_distributions', function ($token, $event, $dates) {

                return $this
                    ->metricBucket
                    ->getDistributions($token, $event, $dates);
            }),
        ];
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
