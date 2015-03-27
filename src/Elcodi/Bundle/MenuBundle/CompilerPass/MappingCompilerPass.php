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

namespace Elcodi\Bundle\MenuBundle\CompilerPass;

use Mmoreram\SimpleDoctrineMapping\CompilerPass\Abstracts\AbstractMappingCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MappingCompilerPass
 */
class MappingCompilerPass extends AbstractMappingCompilerPass
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this
            ->addEntityMapping(
                $container,
                'elcodi.core.menu.entity.menu.manager',
                'elcodi.core.menu.entity.menu.class',
                'elcodi.core.menu.entity.menu.mapping_file',
                'elcodi.core.menu.entity.menu.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.menu.entity.menu_node.manager',
                'elcodi.core.menu.entity.menu_node.class',
                'elcodi.core.menu.entity.menu_node.mapping_file',
                'elcodi.core.menu.entity.menu_node.enabled'
            );
    }
}
