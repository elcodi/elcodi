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

namespace Elcodi\Bundle\ReferralProgramBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiReferralProgramExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_referral_program';

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
            "elcodi.core.referral_program.entity.referral_hash.class"        => $config['mapping']['referral_hash']['class'],
            "elcodi.core.referral_program.entity.referral_hash.mapping_file" => $config['mapping']['referral_hash']['mapping_file'],
            "elcodi.core.referral_program.entity.referral_hash.manager"      => $config['mapping']['referral_hash']['manager'],
            "elcodi.core.referral_program.entity.referral_hash.enabled"      => $config['mapping']['referral_hash']['enabled'],

            "elcodi.core.referral_program.entity.referral_line.class"        => $config['mapping']['referral_line']['class'],
            "elcodi.core.referral_program.entity.referral_line.mapping_file" => $config['mapping']['referral_line']['mapping_file'],
            "elcodi.core.referral_program.entity.referral_line.manager"      => $config['mapping']['referral_line']['manager'],
            "elcodi.core.referral_program.entity.referral_line.enabled"      => $config['mapping']['referral_line']['enabled'],

            "elcodi.core.referral_program.entity.referral_rule.class"        => $config['mapping']['referral_rule']['class'],
            "elcodi.core.referral_program.entity.referral_rule.mapping_file" => $config['mapping']['referral_rule']['mapping_file'],
            "elcodi.core.referral_program.entity.referral_rule.manager"      => $config['mapping']['referral_rule']['manager'],
            "elcodi.core.referral_program.entity.referral_rule.enabled"      => $config['mapping']['referral_rule']['enabled'],

            'elcodi.core.referral_program.controller_route_name'             => $config['controller_route_name'],
            'elcodi.core.referral_program.controller_route'                  => $config['controller_route'],
            'elcodi.core.referral_program.controller_redirect_route_name'    => $config['controller_redirect_route_name'],
            'elcodi.core.referral_program.purge_disabled_lines'              => $config['purge_disabled_lines'],
            'elcodi.core.referral_program.auto_referral_assignment'          => $config['auto_referral_assignment'],
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
            'services',
            'eventListeners',
            'factories',
            'repositories',
            'objectManagers',
            'controllers',
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
            'Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface' => 'elcodi.core.referral_program.entity.referral_hash.class',
            'Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralLineInterface' => 'elcodi.core.referral_program.entity.referral_line.class',
            'Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface' => 'elcodi.core.referral_program.entity.referral_rule.class',
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
