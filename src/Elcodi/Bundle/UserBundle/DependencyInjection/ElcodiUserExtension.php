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

namespace Elcodi\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This class loads and manages your bundle configuration
 */
class ElcodiUserExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return 'elcodi_user';
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
            "elcodi.core.user.entity.abstract_user.class" => $config['mapping']['abstract_user']['class'],
            "elcodi.core.user.entity.abstract_user.mapping_file" => $config['mapping']['abstract_user']['mapping_file'],
            "elcodi.core.user.entity.abstract_user.manager" => $config['mapping']['abstract_user']['manager'],

            "elcodi.core.user.entity.admin_user.class" => $config['mapping']['admin_user']['class'],
            "elcodi.core.user.entity.admin_user.mapping_file" => $config['mapping']['admin_user']['mapping_file'],
            "elcodi.core.user.entity.admin_user.manager" => $config['mapping']['admin_user']['manager'],

            "elcodi.core.user.entity.customer.class" => $config['mapping']['customer']['class'],
            "elcodi.core.user.entity.customer.mapping_file" => $config['mapping']['customer']['mapping_file'],
            "elcodi.core.user.entity.customer.manager" => $config['mapping']['customer']['manager'],
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
            'eventListeners',
            'services',
            'factories',
            'repositories',
            'wrappers',
            'providers',
            'objectManagers',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\User\Entity\Interfaces\CustomerInterface' => 'elcodi.core.user.entity.customer.class',
            'Elcodi\Component\User\Entity\Interfaces\AdminUserInterface' => 'elcodi.core.user.entity.admin_user.class',
        ];
    }
}
