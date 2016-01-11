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

namespace Elcodi\Bundle\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiMediaExtension.
 */
class ElcodiMediaExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_media';

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
     * Config files to load.
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
            'services',
            'factories',
            'controllers',
            'twig',
            'repositories',
            'objectManagers',
            'transformers',
            'eventDispatchers',
            'directors',
            'adapters',
        ];
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
            'elcodi.entity.image.class' => $config['mapping']['image']['class'],
            'elcodi.entity.image.mapping_file' => $config['mapping']['image']['mapping_file'],
            'elcodi.entity.image.manager' => $config['mapping']['image']['manager'],
            'elcodi.entity.image.enabled' => $config['mapping']['image']['enabled'],

            'elcodi.media_filesystem_service' => $config['filesystem'],

            'elcodi.image_generated_route_host' => $config['images']['generated_route_host'],
            'elcodi.image_view_max_age' => $config['images']['view']['max_age'],
            'elcodi.image_view_shared_max_age' => $config['images']['view']['shared_max_age'],
            'elcodi.image_upload_field_name' => $config['images']['upload']['field_name'],

            'elcodi.image_resize_converter_bin_path' => $config['images']['resize']['converter_bin_path'],
            'elcodi.image_resize_converter_default_profile' => $config['images']['resize']['converter_default_profile'],
        ];
    }

    /**
     * Post load implementation.
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     * @param array            $config    Parsed configuration
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        $container->setAlias(
            'elcodi.media_resize_adapter',
            $config['images']['resize']['adapter']
        );

        $container->setAlias(
            'elcodi.media_filesystem',
            $container->getParameter('elcodi.media_filesystem_service')
        );
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
            'Elcodi\Component\Media\Entity\Interfaces\ImageInterface' => 'elcodi.entity.image.class',
        ];
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
