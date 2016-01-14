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

namespace Elcodi\Component\Rule\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ContextCompilerPass.
 */
class ContextCompilerPass implements CompilerPassInterface
{
    /**
     * Collect services tagged to add context for RuleManager.
     *
     * @param ContainerBuilder $container Container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(
            'elcodi.rule_context'
        );

        $contextProviders = [];
        foreach ($taggedServices as $id => $attributes) {
            $contextProviders[] = new Reference($id);
        }

        $definition = $container->getDefinition(
            'elcodi.expression_language_context_collector'
        );

        $definition->addArgument($contextProviders);
    }
}
