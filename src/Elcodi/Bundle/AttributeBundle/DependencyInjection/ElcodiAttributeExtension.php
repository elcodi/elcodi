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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\AttributeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiAttributeExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_attribute';

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__.'/../Resources/config';
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
            "elcodi.core.attribute.entity.attribute.class" => $config['mapping']['attribute']['class'],
            "elcodi.core.attribute.entity.attribute.mapping_file" => $config['mapping']['attribute']['mapping_file'],
            "elcodi.core.attribute.entity.attribute.manager" => $config['mapping']['attribute']['manager'],
            "elcodi.core.attribute.entity.attribute.enabled" => $config['mapping']['attribute']['enabled'],

            "elcodi.core.attribute.entity.attribute_value.class" => $config['mapping']['value']['class'],
            "elcodi.core.attribute.entity.attribute_value.mapping_file" => $config['mapping']['value']['mapping_file'],
            "elcodi.core.attribute.entity.attribute_value.manager" => $config['mapping']['value']['manager'],
            "elcodi.core.attribute.entity.attribute_value.enabled" => $config['mapping']['value']['enabled'],
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Configuration array
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'factories',
            'repositories',
            'objectManagers',
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
            'Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface' => 'elcodi.core.attribute.entity.attribute.class',
            'Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface' => 'elcodi.core.attribute.entity.attribute_value.class',
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
}
