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

namespace Elcodi\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiPageExtension
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ElcodiPageExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_page';

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
        return new Configuration(static::EXTENSION_NAME);
    }

    /**
     * Config files to load
     *
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ...
     * );
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            [
                'controllers',
                $config['routing']['enabled'],
            ],
            'factories',
            [
                'loaders',
                $config['routing']['enabled'],
            ],
            'objectManagers',
            'renderers',
            'repositories',
            'directors',
        ];
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
            "elcodi.entity.page.class"        => $config['mapping']['page']['class'],
            "elcodi.entity.page.mapping_file" => $config['mapping']['page']['mapping_file'],
            "elcodi.entity.page.manager"      => $config['mapping']['page']['manager'],
            "elcodi.entity.page.enabled"      => $config['mapping']['page']['enabled'],

            "elcodi.core.page.routing.route_name" => $config['routing']['route_name'],
            "elcodi.core.page.routing.route_path" => $config['routing']['route_path'],
            "elcodi.core.page.routing.controller" => $config['routing']['controller'],
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
            'Elcodi\Component\Page\Entity\Interfaces\PageInterface' => 'elcodi.entity.page.class',
        ];
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }

    /**
     * Post load implementation
     *
     * @param array            $config    Parsed configuration
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        if ($config['routing']['enabled']) {
            $loaderId = $config['routing']['loader'];
            $loaderDefinition = $container->findDefinition($loaderId);
            $loaderDefinition->addTag('routing.loader');
            $container->setAlias('elcodi.core.page.router', $loaderId);
        }

        if (!empty($config['renderers'])) {
            $rendererReferences = [];
            foreach ($config['renderers'] as $rendererId) {
                $rendererReferences[] = new Reference($rendererId);
            }

            $controllerId = 'elcodi.core.page.chain_renderer';
            $controllerDefinition = $container->findDefinition($controllerId);
            $controllerDefinition->addArgument($rendererReferences);
        }
    }
}
