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

namespace Elcodi\Bundle\BambooBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiBambooExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_bamboo';

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
        $config = $this->checkEmailConfiguration($config);

        return [
            "elcodi.core.bamboo.cache_prefix"                                   => $config['cache_prefix'],
            "elcodi.core.bamboo.store_name"                                     => $config['store_name'],
            "elcodi.core.bamboo.store_template"                                 => $config['store_template'],
            "elcodi.core.bamboo.store_templates"                                => $config['store_templates'],

            "elcodi.core.bamboo.emails.layout"                                  => $config['emails']['defaults']['layout'],
            "elcodi.core.bamboo.emails.sender_email"                            => $config['emails']['defaults']['sender_email'],

            "elcodi.core.bamboo.emails.customer_password_remember.enabled"      => $config['emails']['customer_password_remember']['enabled'],
            "elcodi.core.bamboo.emails.customer_password_remember.template"     => $config['emails']['customer_password_remember']['template'],
            "elcodi.core.bamboo.emails.customer_password_remember.layout"       => $config['emails']['customer_password_remember']['layout'],
            "elcodi.core.bamboo.emails.customer_password_remember.sender_email" => $config['emails']['customer_password_remember']['sender_email'],

            "elcodi.core.bamboo.emails.customer_password_recover.enabled"       => $config['emails']['customer_password_recover']['enabled'],
            "elcodi.core.bamboo.emails.customer_password_recover.template"      => $config['emails']['customer_password_recover']['template'],
            "elcodi.core.bamboo.emails.customer_password_recover.layout"        => $config['emails']['customer_password_recover']['layout'],
            "elcodi.core.bamboo.emails.customer_password_recover.sender_email"  => $config['emails']['customer_password_recover']['sender_email'],
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
            'commands',
            [
                'emails/customerPasswordRemember',
                $config['emails']['customer_password_remember']['enabled']
            ],
            [
                'emails/customerPasswordRecover',
                $config['emails']['customer_password_recover']['enabled']
            ],
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
     * Check the email configuration
     *
     * @param array $config Configuration
     *
     * @return array Configuration checked
     */
    public function checkEmailConfiguration(array $config)
    {
        $layoutNamespace = $config['emails']['defaults']['layout'];
        $senderEmail = $config['emails']['defaults']['sender_email'];

        foreach ($config['emails'] as $emailName => $emailConfiguration) {

            if ('defaults' !== $emailName) {

                $config['emails'][$emailName]['layout'] = $emailConfiguration['layout']
                    ?: $layoutNamespace;

                $config['emails'][$emailName]['sender_email'] = $emailConfiguration['sender_email']
                    ?: $senderEmail;
            }
        }

        return $config;
    }
}
