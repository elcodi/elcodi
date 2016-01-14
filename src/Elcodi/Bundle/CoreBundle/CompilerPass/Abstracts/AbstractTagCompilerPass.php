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

namespace Elcodi\Bundle\CoreBundle\CompilerPass\Abstracts;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AbstractTagCompilerPass.
 */
abstract class AbstractTagCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has($this->getCollectorServiceName())) {
            return;
        }

        $definition = $container->findDefinition(
            $this->getCollectorServiceName()
        );

        $taggedServices = $container->findTaggedServiceIds(
            $this->getTagName()
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                $this->getCollectorMethodName(),
                [new Reference($id)]
            );
        }
    }

    /**
     * Get collector service name.
     *
     * @return string Collector service name
     */
    abstract public function getCollectorServiceName();

    /**
     * Get collector method name.
     *
     * @return string Collector method name
     */
    abstract public function getCollectorMethodName();

    /**
     * Get tag name.
     *
     * @return string Tag name
     */
    abstract public function getTagName();
}
