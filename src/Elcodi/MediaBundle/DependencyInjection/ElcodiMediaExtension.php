<?php

/**
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

namespace Elcodi\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiMediaExtension
 */
class ElcodiMediaExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
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
            'classes',
            'services',
            'factories',
            'controllers',
            'twig',
            'repositories',
            'objectManagers',
            'transformers',
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
            'elcodi.core.media.filesystem'                             => $config['filesystem'],

            'elcodi.core.media.image_view_controller_route_name'       => $config['images']['view']['controller_route_name'],
            'elcodi.core.media.image_view_controller_route'            => $config['images']['view']['controller_route'],
            'elcodi.core.media.image_view_max_age'                     => $config['images']['view']['max_age'],
            'elcodi.core.media.image_view_shared_max_age'              => $config['images']['view']['shared_max_age'],

            'elcodi.core.media.image_upload_field_name'                => $config['images']['upload']['field_name'],
            'elcodi.core.media.image_upload_controller_route_name'     => $config['images']['upload']['controller_route_name'],
            'elcodi.core.media.image_upload_controller_route'          => $config['images']['upload']['controller_route'],

            'elcodi.core.media.image_resize_engine'                    => $config['images']['resize']['engine'],
            'elcodi.core.media.image_resize_controller_route_name'     => $config['images']['resize']['controller_route_name'],
            'elcodi.core.media.image_resize_controller_route'          => $config['images']['resize']['controller_route'],
            'elcodi.core.media.image_resize_converter_bin_path'        => $config['images']['resize']['converter_bin_path'],
            'elcodi.core.media.image_resize_converter_default_profile' => $config['images']['resize']['converter_default_profile'],
        ];
    }

    /**
     * Post load implementation
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function postLoad(ContainerBuilder $container)
    {
        $container->setAlias(
            'elcodi.core.media.resize.default',
            'elcodi.core.media.resize.' . $container->getParameter('elcodi.core.media.image_resize_engine')
        );

        $container->setAlias(
            'elcodi.core.media.filesystem.default',
            $container->getParameter('elcodi.core.media.filesystem')
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
            'Elcodi\MediaBundle\Entity\Interfaces\ImageInterface' => 'elcodi.core.media.entity.image.class',
        ];
    }
}
