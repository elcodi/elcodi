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

namespace Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class AbstractExtension
 */
abstract class AbstractExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    abstract public function getConfigFilesLocation();

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return null;
    }

    /**
     * Config files to load
     *
     * Each array position can be a simple file name if must be loaded always,
     * or an array, with the filename in the first position, and a boolean in
     * the second one.
     *
     * As a parameter, this method receives all loaded configuration, to allow
     * setting this boolean value from a configuration value.
     *
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ['file3.yml', $config['my_boolean'],
     *      ...
     * );
     *
     * @param array $config Config definitions
     *
     * @return array Config files
     */
    abstract public function getConfigFiles(array $config);

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
        return null;
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
        return [];
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = $this->getConfigurationInstance();

        if ($configuration instanceof ConfigurationInterface) {

            $config = $this->processConfiguration($configuration, $config);
            $parametrizationValues = $this->getParametrizationValues($config);

            if (is_array($parametrizationValues)) {

                foreach ($parametrizationValues as $parameter => $value) {

                    $container->setParameter($parameter, $value);
                }
            }
        }

        $configFiles = $this->getConfigFiles($config);

        if (!empty($configFiles)) {

            $loader = new YamlFileLoader($container, new FileLocator($this->getConfigFilesLocation()));

            foreach ($configFiles as $configFile) {

                if (is_array($configFile)) {

                    if (isset($configFile[1]) && $configFile[1] === false) {

                        continue;
                    }

                    $configFile = $configFile[0];
                }

                $loader->load($configFile . '.yml');
            }
        }

        $this->postLoad($container);
    }

    /**
     * Loads a specific configuration.
     *
     * @param ConfigurationInterface $configuration Configuration instance
     * @param array                  $config        An array of configuration values
     * @param ContainerBuilder       $container     A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function loadMappingConfiguration(
        ContainerBuilder $container,
        ConfigurationInterface $configuration,
        array $config
    )
    {
        $config = $this->processConfiguration($configuration, $config);
        $mappingParametrizationValues = $this->getParametrizationValues($config);

        if (is_array($mappingParametrizationValues)) {

            foreach ($mappingParametrizationValues as $parameter => $value) {

                $container->setParameter($parameter, $value);
            }
        }
    }

    /**
     * Post load implementation
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function postLoad(ContainerBuilder $container)
    {

    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        if (!($this instanceof EntitiesOverridableExtensionInterface)) {
            return;
        }

        $mappingConfiguration = $this->getConfigurationInstance();

        if ($mappingConfiguration instanceof ConfigurationInterface) {

            $config = $container->getExtensionConfig($this::getExtensionName());
            $config = $container->getParameterBag()->resolveValue($config);

            $tmpContainer = new ContainerBuilder($container->getParameterBag());
            $tmpContainer->setResourceTracking($container->isTrackingResources());
            $tmpContainer->addObjectResource($this);

            $this->loadMappingConfiguration(
                $tmpContainer,
                $mappingConfiguration,
                $config
            );

            $container->merge($tmpContainer);
        }

        /**
         * Perform overrides for Doctrine ORM mapping resolves
         */
        $overrides = $this->getEntitiesOverrides();
        foreach ($overrides as $interface => $override) {

            $overrides[$interface] = $container->getParameter($override);
        }

        $container->prependExtensionConfig('doctrine', [
            'orm' => [
                'resolve_target_entities' => $overrides
            ]
        ]);
    }
}
