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

namespace Elcodi\RuleBundle\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ExpressionLanguageCompilerPass
 */
class ExpressionLanguageCompilerPass implements CompilerPassInterface
{
    /**
     * This compiler pass computes all services that want to configure the
     * RuleManager expression language instance, adding them some context
     *
     * @param ContainerBuilder $container Container
     */
    public function process(ContainerBuilder $container)
    {
        /**
         * We get our eventlistener
         */
        $definition = $container->getDefinition(
            'elcodi.core.rule.configuration.expression_language_collection'
        );

        /**
         * We get all tagged services
         */
        $taggedServices = $container->findTaggedServiceIds(
            'elcodi.rule_expression_language_configuration'
        );

        /**
         * We add every tagged Resolver into EventListener
         */
        foreach ($taggedServices as $id => $attributes) {

            $definition->addMethodCall(
                'addExpressionLanguageConfiguration',
                array(new Reference($id))
            );
        }
    }
}
