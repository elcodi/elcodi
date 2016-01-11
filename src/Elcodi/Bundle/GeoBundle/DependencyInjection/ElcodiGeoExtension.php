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

namespace Elcodi\Bundle\GeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class ElcodiGeoExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_geo';

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
        return new Configuration(static::EXTENSION_NAME);
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
            'elcodi.entity.address.class' => $config['mapping']['address']['class'],
            'elcodi.entity.address.mapping_file' => $config['mapping']['address']['mapping_file'],
            'elcodi.entity.address.manager' => $config['mapping']['address']['manager'],
            'elcodi.entity.address.enabled' => $config['mapping']['address']['enabled'],

            'elcodi.entity.location.class' => $config['mapping']['location']['class'],
            'elcodi.entity.location.mapping_file' => $config['mapping']['location']['mapping_file'],
            'elcodi.entity.location.manager' => $config['mapping']['location']['manager'],
            'elcodi.entity.location.enabled' => $config['mapping']['location']['enabled'],

            'elcodi.location_api_host' => $config['location']['api_host'],
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
            'commands',
            'controllers',
            'directors',
            'factories',
            'objectManagers',
            'repositories',
            'services',
            'transformers',
            'eventDispatchers',
            'formatters',
            'adapters',
            'validator',
        ];
    }

    /**
     * Get entities overrides.
     *
     * Result must be an array with:
     * index: Original Interface
     * value: Parameter where class is defined.
     *
     * @return array Overrides definition
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface' => 'elcodi.entity.address.class',
            'Elcodi\Component\Geo\Entity\Interfaces\LocationInterface' => 'elcodi.entity.location.class',
        ];
    }

    /**
     * Post load implementation.
     *
     * @param array            $config    Parsed configuration
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        $locatorProviderId = $config['location']['provider_adapter'];
        $container->setAlias('elcodi.location_provider', $locatorProviderId);

        $locatorPopulatorAdapterId = $config['location']['populator_adapter'];
        $container->setAlias('elcodi.location_populator_adapter', $locatorPopulatorAdapterId);

        $locatorLoaderAdapterId = $config['location']['loader_adapter'];
        $container->setAlias('elcodi.location_loader_adapter', $locatorLoaderAdapterId);
    }

    /**
     * Returns the extension alias, same value as extension name.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
}
