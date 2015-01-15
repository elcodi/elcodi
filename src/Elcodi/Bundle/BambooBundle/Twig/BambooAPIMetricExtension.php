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

namespace Elcodi\Bundle\BambooBundle\Twig;

use Twig_SimpleFunction;

use Elcodi\Component\Metric\API\Twig\APIMetricExtension;

/**
 * Class BambooAPIMetricExtension
 */
class BambooAPIMetricExtension extends APIMetricExtension
{
    /**
     * @var string
     *
     * Store tracker
     */
    protected $storeTracker;

    /**
     * Sets StoreToken
     *
     * @param string $storeTracker Store Tracker
     *
     * @return $this Self object
     */
    public function setStoreTracker($storeTracker)
    {
        $this->storeTracker = $storeTracker;

        return $this;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[] An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('bamboo_metric_count', array($this, 'getBambooMetricCount'))
        ];
    }

    /**
     * Return metric counter
     *
     * @param string $event Token
     * @param string $date  Date
     *
     * @return string Html content
     */
    public function getBambooMetricCount(
        $event,
        $date
    )
    {
        return parent::getMetricCount(
            $this->storeTracker,
            $event,
            $date
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'bamboo_api_metric_extension';
    }
}
