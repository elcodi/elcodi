<?php

/**
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

namespace Elcodi\Bundle\ProductBundle\CompilerPass;

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
                'elcodi.core.product.entity.product.manager',
                'elcodi.core.product.entity.product.class',
                'elcodi.core.product.entity.product.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.product.entity.variant.manager',
                'elcodi.core.product.entity.variant.class',
                'elcodi.core.product.entity.variant.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.product.entity.category.manager',
                'elcodi.core.product.entity.category.class',
                'elcodi.core.product.entity.category.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.product.entity.manufacturer.manager',
                'elcodi.core.product.entity.manufacturer.class',
                'elcodi.core.product.entity.manufacturer.mapping_file'
            );
    }
}
