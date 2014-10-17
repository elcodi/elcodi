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

namespace Elcodi\Component\Rule\Configuration;

use Elcodi\Component\Rule\Configuration\Interfaces\ContextConfigurationInterface;

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
