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

namespace Elcodi\Bundle\AttributeBundle\CompilerPass;

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
                'elcodi.core.attribute.entity.attribute.manager',
                'elcodi.core.attribute.entity.attribute.class',
                'elcodi.core.attribute.entity.attribute.mapping_file',
                'elcodi.core.attribute.entity.attribute.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.attribute.entity.attribute_value.manager',
                'elcodi.core.attribute.entity.attribute_value.class',
                'elcodi.core.attribute.entity.attribute_value.mapping_file',
                'elcodi.core.attribute.entity.attribute_value.enabled'
            );
    }
}
