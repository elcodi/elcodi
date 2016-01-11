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

namespace Elcodi\Bundle\PluginBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Component\Plugin\Services\Traits\PluginUtilsTrait;

/**
 * Class ElcodiPluginExtension.
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ElcodiPluginExtension extends AbstractExtension
{
    use PluginUtilsTrait;

    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_plugin';

    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    /**
     * Constructor.
     *
     * @param KernelInterface $kernel Kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Get the Config file location.
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
     * Load Parametrization definition.
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
            'elcodi.entity.plugin.class' => $config['mapping']['plugin']['class'],
            'elcodi.entity.plugin.mapping_file' => $config['mapping']['plugin']['mapping_file'],
            'elcodi.entity.plugin.manager' => $config['mapping']['plugin']['manager'],
            'elcodi.entity.plugin.enabled' => $config['mapping']['plugin']['enabled'],

            'elcodi.entity.plugin_configuration.class' => $config['mapping']['plugin_configuration']['class'],
            'elcodi.entity.plugin_configuration.mapping_file' => $config['mapping']['plugin_configuration']['mapping_file'],
            'elcodi.entity.plugin_configuration.manager' => $config['mapping']['plugin_configuration']['manager'],
            'elcodi.entity.plugin_configuration.enabled' => $config['mapping']['plugin_configuration']['enabled'],
        ];
    }

    /**
     * Config files to load.
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
     * Override Doctrine entities.
     *
     * @param ContainerBuilder $container Container
     *
     * @return $this Self object
     */
    protected function overrideEntities(ContainerBuilder $container)
    {
        $plugins = $this->getInstalledPluginBundles($this->kernel);

        foreach ($plugins as $plugin) {
            $configuration = $this->processPlugin($plugin);
            foreach ($configuration as $name => $config) {
                $container
                    ->prependExtensionConfig(
                        $name,
                        $config
                    );
            }
        }

        return $this;
    }

    /**
     * Process plugin.
     *
     * @param Bundle $plugin Plugin
     *
     * @return array Plugin configuration
     */
    protected function processPlugin(Bundle $plugin)
    {
        $resourcePath = $plugin->getPath() . '/Resources/config/external.yml';

        return file_exists($resourcePath)
            ? Yaml::parse(file_get_contents($resourcePath))
            : [];
    }

    /**
     * Returns the extension alias, same value as extension name.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return self::EXTENSION_NAME;
    }
}
