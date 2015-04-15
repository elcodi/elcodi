<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Plugin\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Plugin\Services\PluginManager;

/**
 * Class PluginExtension for Twig
 *
 * @author Berny Cantos <be@rny.cc>
 */
class PluginExtension extends Twig_Extension
{
    /**
     * Plugin manager
     *
     * @var PluginManager
     */
    protected $pluginManager;

    /**
     * Constructor
     *
     * @param PluginManager $pluginManager Plugin manager
     */
    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'elcodi_plugin',
                function ($namespace) {

                    if (
                        !$this
                            ->pluginManager
                            ->hasPlugin($namespace)
                    ) {
                        return false;
                    }

                    return $this
                        ->pluginManager
                        ->getPlugin($namespace);
                }
            ),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'plugin_extension';
    }
}
