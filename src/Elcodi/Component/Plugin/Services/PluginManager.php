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

namespace Elcodi\Component\Plugin\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

use Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException;
use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\PluginInterface;

/**
 * Class PluginManager
 */
class PluginManager
{
    /**
     * @var array
     *
     * Kernel
     */
    protected $kernel;

    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Construct
     *
     * @param KernelInterface      $kernel               Kernel
     * @param ConfigurationManager $configurationManager Configuration Manager
     */
    public function __construct(
        KernelInterface $kernel,
        ConfigurationManager $configurationManager = null
    )
    {
        $this->kernel = $kernel;
        $this->configurationManager = $configurationManager;
    }

    /**
     * Load templates
     *
     * @return array Templates found
     *
     * @throws ConfigurationParameterNotFoundException Parameter not found
     * @throws Exception                               ConfigurationBundle not installed
     */
    public function loadPlugins()
    {
        if (!($this->configurationManager instanceof ConfigurationManager)) {

            throw new Exception('You need to install ConfigurationBundle');
        }

        $plugins = $this
            ->configurationManager
            ->get('store.plugins');

        $plugins = new ArrayCollection($plugins);
        $bundles = $this->kernel->getBundles();
        $bundlesFound = [];

        /**
         * We add new Plugins found but we don't touch old configurations
         *
         * @var Bundle $bundle
         */
        foreach ($bundles as $bundle) {

            if ($bundle instanceof PluginInterface) {

                $bundleName = $bundle->getName();
                $bundleNamespace = $bundle->getNamespace();
                $bundlesFound[] = $bundleNamespace;

                $specification = array_merge(
                    [
                        'bundle'              => $bundleName,
                        'namespace'           => $bundleNamespace,
                        'name'                => 'Unnamed',
                        'description'         => '',
                        'version'             => 'Any',
                        'author'              => 'Anonymous',
                        'year'                => 'NaN',
                        'url'                 => '',
                        'fa_icon'             => 'gear',
                        'configuration_route' => null,
                        'enabled'             => false,
                        'configuration'       => []
                    ],
                    $this->getPluginSpecification($bundle->getPath())
                );

                $plugins->set($bundleNamespace, $specification);
            }
        }

        /**
         * We remove old plugin references
         */
        foreach ($plugins as $pluginNamespace => $plugin) {

            if (!in_array($pluginNamespace, $bundlesFound)) {

                unset($plugins[$pluginNamespace]);
            }
        }

        $pluginsArray = $plugins->toArray();

        $this
            ->configurationManager
            ->set('store.plugins', $pluginsArray);

        return $pluginsArray;
    }

    /**
     * Read plugin specification
     *
     * @param string $bundlePath Bundle path
     *
     * @return array Plugin specification
     */
    protected function getPluginSpecification($bundlePath)
    {
        $yaml = new Parser();
        $specificationFilePath = $bundlePath . '/plugin.yml';

        if (!file_exists($specificationFilePath)) {
            return [];
        }

        return array_intersect_key(
            $yaml->parse(file_get_contents($specificationFilePath)),
            array_flip([
                'name',
                'author',
                'url',
                'description',
                'year',
                'version',
                'fa_icon',
                'configuration_route',
            ])
        );
    }

    /**
     * Get plugins
     *
     * @return array Plugins
     */
    public function getPlugins()
    {
        $plugins = $this
            ->configurationManager
            ->get('store.plugins');

        foreach ($plugins as $pluginKey => $plugin) {

            $plugins[$pluginKey] = $this->hidratePlugin($plugin);
        }

        return $plugins;
    }

    /**
     * Get plugins
     *
     * @param string $pluginNamespace Plugin namespace
     *
     * @return Plugin Selected plugin
     */
    public function getPlugin($pluginNamespace)
    {
        return $this->getPlugins()[$pluginNamespace];
    }

    /**
     * Update plugin configuration
     *
     * @param string  $pluginNamespace Plugin namespace
     * @param boolean $enabled         Enabled
     * @param array   $configuration   Configuration
     *
     * @return $this Self Object
     */
    public function updatePlugin(
        $pluginNamespace,
        $enabled,
        array $configuration = []
    )
    {
        $plugins = $this
            ->configurationManager
            ->get('store.plugins');

        $plugins[$pluginNamespace]['enabled'] = $enabled;
        $plugins[$pluginNamespace]['configuration'] = array_merge(
            $plugins[$pluginNamespace]['configuration'],
            $configuration
        );

        $this
            ->configurationManager
            ->set('store.plugins', $plugins);

        return $this->hidratePlugin($plugins[$pluginNamespace]);
    }

    /**
     * Hidrate plugin
     *
     * @param array $plugin Plugin data
     *
     * @return Plugin Hidratation
     */
    protected function hidratePlugin(array $plugin)
    {
        return new Plugin(
            $plugin['author'],
            $plugin['bundle'],
            $plugin['configuration'],
            $plugin['configuration_route'],
            $plugin['description'],
            $plugin['enabled'],
            $plugin['fa_icon'],
            $plugin['name'],
            $plugin['namespace'],
            $plugin['url'],
            $plugin['version'],
            $plugin['year']
        );
    }
}
