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

namespace Elcodi\Bundle\EntityTranslatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This class loads and manages your bundle configuration
 */
class ElcodiEntityTranslatorExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_entity_translator';

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
            "elcodi.core.entity_translator.entity.entity_translation.class"        => $config['mapping']['translation']['class'],
            "elcodi.core.entity_translator.entity.entity_translation.mapping_file" => $config['mapping']['translation']['mapping_file'],
            "elcodi.core.entity_translator.entity.entity_translation.manager"      => $config['mapping']['translation']['manager'],
            "elcodi.core.entity_translator.entity.entity_translation.enabled"      => $config['mapping']['translation']['enabled'],

            "elcodi.core.entity_translator.configuration"                          => $config['configuration'],
            "elcodi.core.entity_translator.cache_prefix"                           => $config['cache_prefix'],
            "elcodi.core.entity_translator.auto_translate"                         => $config['auto_translate'],
            "elcodi.core.entity_translator.language_master_locale"                 => $config['language']['master_locale'],
            "elcodi.core.entity_translator.language_fallback"                      => $config['language']['fallback']
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Configuration
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
            'services',
            'eventDispatchers',
            'eventListeners',
            ['autoloadEventListeners', $config['auto_translate']]
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\EntityTranslator\Entity\Interfaces\EntityTranslationInterface' => 'elcodi.core.entity_translator.entity.entity_translation.class',
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
