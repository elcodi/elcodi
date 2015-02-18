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

namespace Elcodi\Bundle\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class ElcodiSitemapExtension
 */
class ElcodiSitemapExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_sitemap';

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

        ];
    }

    /**
     * Hook after load the full container
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        $this
            ->loadBlocks($config, $container)
            ->loadProfiles($config, $container)
            ->loadDumpers($config, $container)
            ->loadDumperChain($config, $container)
            ->loadCommands($config, $container);
    }

    /**
     * Load blocks
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     *
     * @return $this self Object
     */
    protected function loadBlocks(array $config, ContainerBuilder $container)
    {
        $blocks = $config['blocks'];

        foreach ($blocks as $blockName => $block) {
            $container
                ->register(
                    'elcodi.sitemap_entity_loader.'.$blockName,
                    '%elcodi.core.sitemap.loader.entity_loader.class%'
                )
                ->addArgument(new Reference($block['transformer']))
                ->addArgument(new Reference($block['repository_service']))
                ->addArgument($block['method'])
                ->addArgument($block['arguments'])
                ->setPublic(false);
        }

        return $this;
    }

    /**
     * Load profiles
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     *
     * @return $this self Object
     */
    protected function loadProfiles(array $config, ContainerBuilder $container)
    {
        $profiles = $config['profiles'];

        foreach ($profiles as $profileName => $profile) {
            $definition = $container
                ->register(
                    'elcodi.sitemap_profile.'.$profileName,
                    '%elcodi.core.sitemap.loader.profile.class%'
                )
                ->addArgument($profileName)
                ->addArgument($profile['path'])
                ->setPublic(true);

            foreach ($profile['blocks'] as $profileBlockName) {
                $definition->addMethodCall(
                    'addEntityLoader',
                    [new Reference('elcodi.sitemap_entity_loader.'.$profileBlockName)]
                );
            }
        }

        return $this;
    }

    /**
     * Load dumpers
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     *
     * @return $this self Object
     */
    protected function loadDumpers(array $config, ContainerBuilder $container)
    {
        $profiles = $config['profiles'];

        foreach ($profiles as $profileName => $profile) {
            $container
                ->register(
                    'elcodi.sitemap_dumper.'.$profileName,
                    '%elcodi.sitemap_dumper.class%'
                )
                ->addArgument(new Reference($profile['render']))
                ->addArgument(new Reference('elcodi.sitemap_profile.'.$profileName))
                ->addArgument(new Reference('elcodi.event_dispatcher.sitemap'))
                ->setPublic(true)
                ->addTag('elcodi.sitemap_dumper');
        }

        return $this;
    }

    /**
     * Load dumper chain
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     *
     * @return $this self Object
     */
    protected function loadDumperChain(array $config, ContainerBuilder $container)
    {
        if (!$container->hasDefinition('elcodi.sitemap_dumper_chain')) {
            return $this;
        }

        $sitemapDumperChain = $container->getDefinition('elcodi.sitemap_dumper_chain');

        $sitemapDumpers = $container->findTaggedServiceIds(
            'elcodi.sitemap_dumper'
        );

        foreach ($sitemapDumpers as $sitemapDumperId => $tags) {
            $sitemapDumperChain->addMethodCall(
                'addSitemapDumper',
                array(new Reference($sitemapDumperId))
            );
        }

        return $this;
    }

    /**
     * Load commands
     *
     * @param array            $config    Configuration
     * @param ContainerBuilder $container Container
     *
     * @return $this self Object
     */
    protected function loadCommands(array $config, ContainerBuilder $container)
    {
        $profiles = $config['profiles'];

        foreach ($profiles as $profileName => $profile) {
            $container
                ->register(
                    'elcodi.sitemap_command.'.$profileName,
                    '%elcodi.core.sitemap.command.dump_sitemap.class%'
                )
                ->addArgument(new Reference('elcodi.sitemap_dumper.'.$profileName))
                ->setPublic(true)
                ->addTag('console.command');
        }

        return $this;
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
            'renders',
            'eventDispatchers',
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
