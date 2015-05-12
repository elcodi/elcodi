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

namespace Elcodi\Bundle\PluginBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class ElcodiPluginExtension
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ElcodiPluginExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_plugin';

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Return a new Configuration instance.
     *
     * If object returned by this method is an instance of
     * ConfigurationInterface, extension will use the Configuration to read all
     * bundle config definitions.
     *
     * Also will call getParametrizationValues method to load some config values
     * to internal parameters.
     *
     * @return ConfigurationInterface Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration($this->getAlias());
    }

    /**
     * Load Parametrization definition
     *
     * return array(
     *      'parameter1' => $config['parameter1'],
     *      'parameter2' => $config['parameter2'],
     *      ...
     * );
     *
     * @param array $config Bundles config values
     *
     * @return array Parametrization values
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            "elcodi.entity.plugin.class"                      => $config['mapping']['plugin']['class'],
            "elcodi.entity.plugin.mapping_file"               => $config['mapping']['plugin']['mapping_file'],
            "elcodi.entity.plugin.manager"                    => $config['mapping']['plugin']['manager'],
            "elcodi.entity.plugin.enabled"                    => $config['mapping']['plugin']['enabled'],

            "elcodi.entity.plugin_configuration.class"        => $config['mapping']['plugin_configuration']['class'],
            "elcodi.entity.plugin_configuration.mapping_file" => $config['mapping']['plugin_configuration']['mapping_file'],
            "elcodi.entity.plugin_configuration.manager"      => $config['mapping']['plugin_configuration']['manager'],
            "elcodi.entity.plugin_configuration.enabled"      => $config['mapping']['plugin_configuration']['enabled'],
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'services',
            'repositories',
            'objectManagers',
            'commands',
            'eventDispatchers',
            'formTypes',
            'twig',
        ];
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return self::EXTENSION_NAME;
    }
}
