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

namespace Elcodi\Bundle\CommentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Elcodi\Component\Comment\Adapter\Parser\DummyParserAdapter;
use Elcodi\Component\Comment\Adapter\Parser\MarkdownParserAdapter;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->extensionName);

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'comment',
                            'Elcodi\Component\Comment\Entity\Comment',
                            '@ElcodiCommentBundle/Resources/config/doctrine/Comment.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'vote',
                            'Elcodi\Component\Comment\Entity\Vote',
                            '@ElcodiCommentBundle/Resources/config/doctrine/Vote.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('comments')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('cache_key')
                            ->defaultValue('comments')
                        ->end()
                        ->enumNode('parser')
                            ->values([
                                DummyParserAdapter::ADAPTER_NAME,
                                MarkdownParserAdapter::ADAPTER_NAME
                            ])
                            ->defaultValue(DummyParserAdapter::ADAPTER_NAME)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
