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

namespace Elcodi\Component\Plugin\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Entity\PluginConfiguration;
use Elcodi\Component\Plugin\Repository\PluginRepository;
use Elcodi\Component\Plugin\Services\Traits\PluginUtilsTrait;

/**
 * Class PluginManager.
 */
class PluginManager
{
    use PluginUtilsTrait;

    /**
     * @var KernelInterface
     *
     * Kernel
     */
    private $kernel;

    /**
     * @var PluginRepository
     *
     * Plugin repository
     */
    private $pluginRepository;

    /**
     * @var ObjectManager
     *
     * Plugin object manager
     */
    private $pluginObjectManager;

    /**
     * @var PluginLoader
     *
     * Plugin Loader
     */
    private $pluginLoader;

    /**
     * Construct.
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
        $oldPlugins = $this->getExistingPlugins();
        $pluginBundles = $this->getInstalledPluginBundles($this->kernel);
        $pluginsLoaded = [];

        /**
         * @var Bundle $plugin
         */
        foreach ($pluginBundles as $plugin) {
            $pluginConfiguration = $this
                ->pluginLoader
                ->getPluginConfiguration($plugin->getPath());

            $pluginNamespace = get_class($plugin);
            $pluginInstance = $this
                ->getPluginInstance(
                    $pluginNamespace,
                    $pluginConfiguration
                );

            if (isset($oldPlugins[$pluginNamespace])) {
                $existingPlugin = $oldPlugins[$pluginNamespace];
                $pluginInstance = $existingPlugin->merge($pluginInstance);
                unset($oldPlugins[$pluginNamespace]);
            }

            $this->savePlugin($pluginInstance);

            $pluginsLoaded[] = $pluginInstance;
        }

        /**
         * Every Plugin instance inside $plugins array should be removed from
         * database, because they are not longer installed.
         */
        $this->removePlugins($oldPlugins);

        return $pluginsLoaded;
    }

    /**
     * Load existing plugins from database and return an array with them all,
     * indexed by its namespace.
     *
     * @return Plugin[] Plugins indexed by namespace
     */
    private function getExistingPlugins()
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
     * Create or update existing plugin given a set of plugin instances and the
     * information to create a new one.
     *
     * @param string $pluginNamespace     Plugin namespace
     * @param array  $pluginConfiguration Plugin Configuration
     *
     * @return Plugin Plugin instance
     */
    private function getPluginInstance(
        $pluginNamespace,
        array $pluginConfiguration
    ) {
        $pluginType = $pluginConfiguration['type'];
        $pluginCategory = $pluginConfiguration['category'];
        $pluginEnabledByDefault = $pluginConfiguration['enabled_by_default'];
        unset($pluginConfiguration['type']);

        $pluginInstance = Plugin::create(
            $pluginNamespace,
            $pluginType,
            $pluginCategory,
            PluginConfiguration::create($pluginConfiguration),
            $pluginEnabledByDefault
        );

        return $pluginInstance;
    }

    /**
     * Saves a plugin into database.
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    private function savePlugin(Plugin $plugin)
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
     * Remove a set of Plugins from database.
     *
     * @param Plugin[] $plugins Plugins
     *
     * @return $this Self object
     */
    private function removePlugins($plugins)
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
