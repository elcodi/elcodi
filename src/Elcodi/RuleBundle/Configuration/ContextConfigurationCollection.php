<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\RuleBundle\Configuration;

use Elcodi\RuleBundle\Configuration\Interfaces\ContextConfigurationInterface;

/**
 * Class ContextConfigurationCollection
 */
class ContextConfigurationCollection
{
    /**
     * @var array
     *
     * Array of ContextConfiguration objects
     */
    protected $contextConfigurations;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->contextConfigurations = array();
    }

    /**
     * Add Context configuration
     *
     * @param ContextConfigurationInterface $contextConfiguration Context Configuration
     */
    public function addContextConfiguration(
        ContextConfigurationInterface $contextConfiguration
    )
    {
        $this->contextConfigurations[] = $contextConfiguration;
    }

    /**
     * Get all context configuration objects
     *
     * @return array Array of all added context configurations
     */
    public function getContextConfigurations()
    {
        return $this->contextConfigurations;
    }
}
