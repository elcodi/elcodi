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
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class AbstractExtension
 */
abstract class AbstractExtension
    implements ExtensionInterface, ConfigurationExtensionInterface, PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function getAlias();

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $configuration = $this->getConfigurationInstance();
        if ($configuration) {
            $container->addObjectResource($configuration);
        }

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->addObjectResource($this);

        $configuration = $this->getConfiguration($config, $container);
        if ($configuration instanceof ConfigurationInterface) {
            $config = $this->processConfiguration($configuration, $config);
            $this->applyParametrizedValues($config, $container);
        }

        $configFiles = $this->getConfigFiles($config);
        if (!empty($configFiles)) {
            $this->loadFiles($configFiles, $container);
        }

        $this->postLoad($config, $container);
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = [];
        $configuration = $this->getConfigurationInstance();
        if ($configuration instanceof ConfigurationInterface) {
            $config = $container->getExtensionConfig($this->getAlias());

            $tmpContainer = new ContainerBuilder($container->getParameterBag());
            $tmpContainer->setResourceTracking($container->isTrackingResources());
            $config = $this->processConfiguration($configuration, $config);
            $config = $container->getParameterBag()->resolveValue($config);
            $this->applyParametrizedValues($config, $tmpContainer);

            $container->merge($tmpContainer);
        }

        $this->overrideEntities($container);

        $this->preLoad($config, $container);
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return 'http://example.org/schema/dic/' . $this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    protected function getConfigFilesLocation()
    {
        throw new \RuntimeException(sprintf(
            'Method "getConfigFiles" returns non-empty, but "getConfigFilesLocation" is missing in "%s" extension.',
            $this->getAlias()
        ));
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
    protected function getConfigFiles(array $config)
    {
        return [];
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
     * Hook after prepending configuration.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function preLoad(array $config, ContainerBuilder $container)
    {
        // Implement here your bundle logic
    }

    /**
     * Hook after load the full container.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        // Implement here your bundle logic
    }

    /**
     * @param ConfigurationInterface $configuration
     * @param array                  $configs
     *
     * @return array
     */
    protected function processConfiguration(ConfigurationInterface $configuration, array $configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function applyParametrizedValues(array $config, ContainerBuilder $container)
    {
        $parametrizationValues = $this->getParametrizationValues($config);
        if (is_array($parametrizationValues)) {
            $container
                ->getParameterBag()
                ->add($parametrizationValues);
        }
    }

    /**
     * Load multiple files
     *
     * @param array            $configFiles
     * @param ContainerBuilder $container
     */
    protected function loadFiles(array $configFiles, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator($this->getConfigFilesLocation()));

        foreach ($configFiles as $configFile) {
            if (is_array($configFile)) {
                if (isset($configFile[1]) && false === $configFile[1]) {
                    continue;
                }

                $configFile = $configFile[0];
            }

            $loader->load($configFile . '.yml');
        }
    }

    /**
     * Override Doctrine entities
     *
     * @param ContainerBuilder $container
     */
    protected function overrideEntities(ContainerBuilder $container)
    {
        if (!$this instanceof EntitiesOverridableExtensionInterface) {
            return;
        }

        $overrides = $this->getEntitiesOverrides();
        foreach ($overrides as $interface => $override) {
            $overrides[$interface] = $container->getParameter($override);
        }

        $container->prependExtensionConfig('doctrine', [
            'orm' => [
                'resolve_target_entities' => $overrides
            ]
        ]);

        $container->prependExtensionConfig('elcodi_core', [
            'mapping_implementations' => $overrides
        ]);
    }
}
