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

namespace Elcodi\Component\Configuration\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

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
     */
    protected $configurationManager;

    /**
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('config_parameter', array($this, 'getParameter'))
        );
    }

    /**
     * Returns a configuration parameter given a parameter name and namespace
     *
     * @param $parameter
     * @param string $namespace
     *
     * @return mixed
     */
    public function getParameter($parameter, $namespace = "")
    {
        return $this
            ->configurationManager
            ->getParameter($parameter, $namespace);
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
