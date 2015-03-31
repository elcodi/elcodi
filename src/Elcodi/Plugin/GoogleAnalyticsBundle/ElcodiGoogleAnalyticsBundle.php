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

namespace Elcodi\Plugin\GoogleAnalyticsBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Component\Plugin\Interfaces\PluginInterface;
use Elcodi\Plugin\GoogleAnalyticsBundle\DependencyInjection\ElcodiGoogleAnalyticsExtension;

/**
 * Class ElcodiGoogleAnalyticsBundle
 */
class ElcodiGoogleAnalyticsBundle extends Bundle implements PluginInterface
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ElcodiGoogleAnalyticsExtension();
    }

    /**
     * Register Commands.
     *
     * Disabled as commands are registered as services.
     *
     * @param Application $application An Application instance
     */
    public function registerCommands(Application $application)
    {
        return;
    }
}
