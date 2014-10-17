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

namespace Elcodi\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;
use Elcodi\Component\Menu\Adapter\RouteGenerator\DummyRouteGeneratorAdapter;
use Elcodi\Component\Menu\Adapter\RouteGenerator\SymfonyRouteGeneratorAdapter;

/**
 * Class ElcodiMenuExtension
 */
class ElcodiMenuExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return 'elcodi_menu';
    }

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
        return new Configuration();
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
            "elcodi.core.menu.entity.menu.class" => $config['mapping']['menu']['class'],
            "elcodi.core.menu.entity.menu.mapping_file" => $config['mapping']['menu']['mapping_file'],
            "elcodi.core.menu.entity.menu.manager" => $config['mapping']['menu']['manager'],

            "elcodi.core.menu.entity.menu_node.class" => $config['mapping']['menu_node']['class'],
            "elcodi.core.menu.entity.menu_node.mapping_file" => $config['mapping']['menu_node']['mapping_file'],
            "elcodi.core.menu.entity.menu_node.manager" => $config['mapping']['menu_node']['manager'],

            'elcodi.core.menu.cache_key' => $config['menus']['cache_key'],
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Config array
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'services',
            'factories',
            'twig',
            'repositories',
            'objectManagers',
            [
                'routeGeneratorAdapters/dummyRouter',
                $config['route_provider']['adapter'] === DummyRouteGeneratorAdapter::ADAPTER_NAME
            ],
            [
                'routeGeneratorAdapters/symfonyRouter',
                $config['route_provider']['adapter'] === SymfonyRouteGeneratorAdapter::ADAPTER_NAME
            ]
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
            'Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface' => 'elcodi.core.menu.entity.menu_node.class',
            'Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface' => 'elcodi.core.menu.entity.menu.class',
        ];
    }

}
