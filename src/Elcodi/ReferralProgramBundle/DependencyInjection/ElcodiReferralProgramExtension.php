<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ReferralProgramBundle\DependencyInjection;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiReferralProgramExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
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
            'elcodi.core.referral_program.controller_route_name'    => $config['controller_route_name'],
            'elcodi.core.referral_program.controller_route'         => $config['controller_route'],
            'elcodi.core.referral_program.controller_redirect'      => $config['controller_redirect'],
            'elcodi.core.referral_program.purge_disabled_lines'     => $config['purge_disabled_lines'],
            'elcodi.core.referral_program.auto_referral_assignment' => $config['auto_referral_assignment'],
        ];
    }

    /**
     * Config files to load
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [
            'classes',
            'formTypes',
            'services',
            'eventListeners',
            'factories',
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
            'Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface' => 'elcodi.core.referral_program.entity.referral_hash.class',
            'Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralLineInterface' => 'elcodi.core.referral_program.entity.referral_line.class',
            'Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface' => 'elcodi.core.referral_program.entity.referral_rule.class',
        ];
    }
}
