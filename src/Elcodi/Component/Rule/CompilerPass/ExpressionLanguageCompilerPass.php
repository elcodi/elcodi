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
 * Class ExpressionLanguageCompilerPass.
 */
class ExpressionLanguageCompilerPass implements CompilerPassInterface
{
    /**
     * Collect services tagged to configure the ExpressionLanguage instance of RuleManager.
     *
     * @param ContainerBuilder $container Container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition(
            'elcodi.expression_language'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'elcodi.rule_configuration'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'registerProvider',
                [
                    new Reference($id),
                ]
            );
        }
    }
}
