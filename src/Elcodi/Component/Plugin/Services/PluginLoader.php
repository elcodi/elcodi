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

namespace Elcodi\Component\Plugin\Services;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Parser;

/**
 * Class PluginLoader.
 */
class PluginLoader
{
    /**
     * Given a Bundle path, return a new PluginConfiguration instance.
     *
     * @param string $pluginPath Plugin Path
     *
     * @return array Plugin configuration
     */
    public function getPluginConfiguration($pluginPath)
    {
        $yaml = new Parser();
        $specificationFilePath = $pluginPath . '/plugin.yml';
        if (!file_exists($specificationFilePath)) {
            return [];
        }

        $parsedConfiguration = $yaml->parse(file_get_contents($specificationFilePath));
        if (!is_array($parsedConfiguration)) {
            return [];
        }

        $processor = new Processor();
        $pluginConfiguration = $processor
            ->processConfiguration(
                new PluginConfigurationTree(),
                $parsedConfiguration
            );

        return $pluginConfiguration;
    }
}
