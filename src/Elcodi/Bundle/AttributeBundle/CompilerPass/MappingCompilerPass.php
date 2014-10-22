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

namespace Elcodi\Bundle\AttributeBundle\CompilerPass;

use Mmoreram\SimpleDoctrineMapping\CompilerPass\Abstracts\AbstractMappingCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MappingCompilerPass
 */
class MappingCompilerPass extends AbstractMappingCompilerPass
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $this
            ->addEntityMapping(
                $container,
                'elcodi.core.attribute.entity.attribute.manager',
                'elcodi.core.attribute.entity.attribute.class',
                'elcodi.core.attribute.entity.attribute.mapping_file',
                'elcodi.core.attribute.entity.attribute.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.attribute.entity.value.manager',
                'elcodi.core.attribute.entity.value.class',
                'elcodi.core.attribute.entity.value.mapping_file',
                'elcodi.core.attribute.entity.value.enabled'
            )
        ;
    }
}
