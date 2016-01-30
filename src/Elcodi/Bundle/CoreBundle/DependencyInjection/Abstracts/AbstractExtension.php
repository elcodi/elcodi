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
 * Class AbstractExtension.
 */
abstract class AbstractExtension
    implements
    ExtensionInterface,
    ConfigurationExtensionInterface,
    PrependExtensionInterface
{
    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     *
     * @api
     */
    abstract public function getAlias();

    /**
     * Returns extension configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @return ConfigurationInterface|null The configuration or null
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
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
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
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = [];
        $configuration = $this->getConfigurationInstance();
        if ($configuration instanceof ConfigurationInterface) {
            $config = $container->getExtensionConfig($this->getAlias());

            $config = $this->processConfiguration($configuration, $config);
            $config = $container->getParameterBag()->resolveValue($config);
            $this->applyParametrizedValues($config, $container);
        }

        $this->overrideEntities($container);

        $this->preLoad($config, $container);
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     *
     * @api
     */
    public function getNamespace()
    {
        return 'http://example.org/schema/dic/' . $this->getAlias();
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     *
     * @api
     */
    public function getXsdValidationBasePath()
    {
        return '';
    }

    /**
     * Get the Config file location.
     *
     * @return string Config file location
     */
    protected function getConfigFilesLocation()
    {
        throw new \RuntimeException(sprintf(
            'Method "getConfigFiles" returns non-empty, but "getConfigFilesLocation" is not implemented in "%s" extension.',
            $this->getAlias()
        ));
    }

    /**
     * Config files to load.
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
        return [];
    }

    /**
     * Hook after pre-pending configuration.
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     */
    protected function preLoad(array $config, ContainerBuilder $container)
    {
        // Implement here your bundle logic
    }

    /**
     * Hook after load the full container.
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        // Implement here your bundle logic
    }

    /**
     * Process configuration.
     *
     * @param ConfigurationInterface $configuration Configuration object
     * @param array                  $configs       Configuration stack
     *
     * @return array configuration processed
     */
    protected function processConfiguration(ConfigurationInterface $configuration, array $configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }

    /**
     * Apply parametrized values.
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     *
     * @return $this Self object
     */
    protected function applyParametrizedValues(array $config, ContainerBuilder $container)
    {
        $parametrizationValues = $this->getParametrizationValues($config);
        if (is_array($parametrizationValues)) {
            $container
                ->getParameterBag()
                ->add($parametrizationValues);
        }

        return $this;
    }

    /**
     * Load multiple files.
     *
     * @param array            $configFiles Config files
     * @param ContainerBuilder $container   Container
     *
     * @return $this Self object
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

        return $this;
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
        if ($this instanceof EntitiesOverridableExtensionInterface) {
            $overrides = $this->getEntitiesOverrides();
            foreach ($overrides as $interface => $override) {
                $overrides[$interface] = $container->getParameter($override);
            }

            $container->prependExtensionConfig('doctrine', [
                'orm' => [
                    'resolve_target_entities' => $overrides,
                ],
            ]);

            $container->prependExtensionConfig('elcodi_core', [
                'mapping_implementations' => $overrides,
            ]);
        }

        return $this;
    }
}
