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

namespace Elcodi\Component\Configuration\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException;
use Elcodi\Component\Configuration\Services\ConfigurationManager;

/**
 * Class ConfigurationExtension
 *
 * Provides a simple twig function to access runtime configuration parameters
 */
class ConfigurationExtension extends Twig_Extension
{
    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Constructor
     *
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('getConfiguration', array($this, 'getParameter')),
        );
    }

    /**
     * Load a parameter given the key and the namespace
     *
     * @param string $parameterKey       Parameter key
     * @param string $parameterNamespace Parameter namespace
     *
     * @return null|string|boolean Configuration parameter value
     *
     * @throws ConfigurationParameterNotFoundException Configuration not found
     */
    public function getParameter(
        $parameterKey,
        $parameterNamespace = ''
    ) {
        return $this
            ->configurationManager
            ->get($parameterKey, $parameterNamespace);
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'configuration_extension';
    }
}
