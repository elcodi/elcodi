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

namespace Elcodi\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This class loads and manages your bundle configuration.
 */
class ElcodiUserExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_user';

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
            'elcodi.entity.abstract_user.class' => $config['mapping']['abstract_user']['class'],
            'elcodi.entity.abstract_user.mapping_file' => $config['mapping']['abstract_user']['mapping_file'],
            'elcodi.entity.abstract_user.manager' => $config['mapping']['abstract_user']['manager'],
            'elcodi.entity.abstract_user.enabled' => $config['mapping']['abstract_user']['enabled'],

            'elcodi.entity.admin_user.class' => $config['mapping']['admin_user']['class'],
            'elcodi.entity.admin_user.mapping_file' => $config['mapping']['admin_user']['mapping_file'],
            'elcodi.entity.admin_user.manager' => $config['mapping']['admin_user']['manager'],
            'elcodi.entity.admin_user.enabled' => $config['mapping']['admin_user']['enabled'],

            'elcodi.entity.customer.class' => $config['mapping']['customer']['class'],
            'elcodi.entity.customer.mapping_file' => $config['mapping']['customer']['mapping_file'],
            'elcodi.entity.customer.manager' => $config['mapping']['customer']['manager'],
            'elcodi.entity.customer.enabled' => $config['mapping']['customer']['enabled'],
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
            'eventListeners',
            'services',
            'factories',
            'repositories',
            'wrappers',
            'providers',
            'objectManagers',
            'directors',
            'eventDispatchers',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\User\Entity\Interfaces\CustomerInterface' => 'elcodi.entity.customer.class',
            'Elcodi\Component\User\Entity\Interfaces\AdminUserInterface' => 'elcodi.entity.admin_user.class',
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
