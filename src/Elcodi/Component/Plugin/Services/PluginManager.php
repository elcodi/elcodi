<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Entity\PluginConfiguration;
use Elcodi\Component\Plugin\Interfaces\PluginInterface;
use Elcodi\Component\Plugin\Repository\PluginRepository;

/**
 * Class PluginManager
 */
class PluginManager
{
    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    /**
     * @var PluginRepository
     *
     * Plugin repository
     */
    protected $pluginRepository;

    /**
     * @var ObjectManager
     *
     * Plugin object manager
     */
    protected $pluginObjectManager;

    /**
     * @var PluginLoader
     *
     * Plugin Loader
     */
    protected $pluginLoader;

    /**
     * @var Plugin[]
     *
     * Cached plugin list
     */
    protected $plugins = [];

    /**
     * Construct
     *
     * @param KernelInterface  $kernel              Kernel
     * @param PluginRepository $pluginRepository    Plugin repository
     * @param ObjectManager    $pluginObjectManager Plugin object manager
     * @param PluginLoader     $pluginLoader        Plugin Loader
     */
    public function __construct(
        KernelInterface $kernel,
        PluginRepository $pluginRepository,
        ObjectManager $pluginObjectManager,
        PluginLoader $pluginLoader
    ) {
        $this->kernel = $kernel;
        $this->pluginRepository = $pluginRepository;
        $this->pluginObjectManager = $pluginObjectManager;
        $this->pluginLoader = $pluginLoader;
    }

    /**
     * Load plugins.
     *
     * This method will look for new plugins installed in our kernel and will
     * try to install them. It will look for already installed plugins as well,
     * and update with new information, maintaining old values.
     *
     * @return Plugin[] Plugins loaded
     */
    public function loadPlugins()
    {
        $plugins = $this->getExistingPlugins();
        $pluginBundles = $this->getInstalledPluginBundles();
        $pluginsLoaded = [];

        /**
         * @var Bundle|PluginInterface $plugin
         */
        foreach ($pluginBundles as $pluginNamespace => $plugin) {
            $pluginConfiguration = $this
                ->pluginLoader
                ->getPluginConfiguration($plugin->getPath());

            $pluginInstance = $this
                ->getPluginInstance(
                    $plugins,
                    $pluginNamespace,
                    $pluginConfiguration
                );

            $this->savePlugin($pluginInstance);

            $pluginsLoaded[] = $pluginInstance;
            if (isset($plugins
                [$pluginNamespace])) {
                unset($plugins[$pluginNamespace]);
            }
        }

        /**
         * Every Plugin instance inside $plugins array should be removed from
         * database, because they are not longer installed
         */
        $this->removePlugins($plugins);

        return $pluginsLoaded;
    }

    /**
     * Load existing plugins from database and return an array with them all,
     * indexed by its namespace
     *
     * @return Plugin[] Plugins indexed by namespace
     */
    protected function getExistingPlugins()
    {
        $pluginsIndexed = [];
        $plugins = $this
            ->pluginRepository
            ->findAll();

        /**
         * @var Plugin $plugin
         */
        foreach ($plugins as $plugin) {
            $pluginNamespace = $plugin->getNamespace();
            $pluginsIndexed[$pluginNamespace] = $plugin;
        }

        return $pluginsIndexed;
    }

    /**
     * Load installed plugin bundles and return an array with them, indexed by
     * their namespaces
     *
     * @return PluginInterface[]|Bundle[] Plugins installed
     */
    protected function getInstalledPluginBundles()
    {
        $plugins = [];
        $bundles = $this
            ->kernel
            ->getBundles();

        foreach ($bundles as $bundle) {

            /**
             * @var Bundle|PluginInterface $bundle
             */
            if ($bundle instanceof PluginInterface) {
                $pluginNamespace = $bundle->getNamespace();
                $plugins[$pluginNamespace] = $bundle;
            }
        }

        return $plugins;
    }

    /**
     * Create or update existing plugin given a set of plugin instances and the
     * information to create a new one
     *
     * @param Plugin[] $plugins             Plugins
     * @param string   $pluginNamespace     Plugin namespace
     * @param array    $pluginConfiguration Plugin Configuration
     *
     * @return Plugin Plugin instance
     */
    protected function getPluginInstance(
        array $plugins,
        $pluginNamespace,
        $pluginConfiguration
    ) {
        $pluginType = $pluginConfiguration['type'];
        $pluginCategory = $pluginConfiguration['category'];
        unset($pluginConfiguration['type']);

        $pluginInstance = Plugin::create(
            $pluginNamespace,
            $pluginType,
            $pluginCategory,
            PluginConfiguration::create($pluginConfiguration)
        );

        if (isset($plugins[$pluginNamespace])) {
            $existingPlugin = $plugins[$pluginNamespace];
            $pluginInstance = $existingPlugin->merge($pluginInstance);
            unset($plugins[$pluginNamespace]);
        }

        return $pluginInstance;
    }

    /**
     * Saves a plugin into database
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    protected function savePlugin(Plugin $plugin)
    {
        $this
            ->pluginObjectManager
            ->persist($plugin);

        $this
            ->pluginObjectManager
            ->flush($plugin);

        return $this;
    }

    /**
     * Remove a set of Plugins from database
     *
     * @param Plugin[] $plugins Plugins
     *
     * @return $this Self object
     */
    protected function removePlugins($plugins)
    {
        foreach ($plugins as $pluginToBeRemoved) {
            $this
                ->pluginObjectManager
                ->remove($pluginToBeRemoved);

            $this
                ->pluginObjectManager
                ->flush($pluginToBeRemoved);
        }

        return $this;
    }
}
