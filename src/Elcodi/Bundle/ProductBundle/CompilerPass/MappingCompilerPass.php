<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
                'elcodi.entity.product.manager',
                'elcodi.entity.product.class',
                'elcodi.entity.product.mapping_file',
                'elcodi.entity.product.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.entity.product_variant.manager',
                'elcodi.entity.product_variant.class',
                'elcodi.entity.product_variant.mapping_file',
                'elcodi.entity.product_variant.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.entity.category.manager',
                'elcodi.entity.category.class',
                'elcodi.entity.category.mapping_file',
                'elcodi.entity.category.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.entity.manufacturer.manager',
                'elcodi.entity.manufacturer.class',
                'elcodi.entity.manufacturer.mapping_file',
                'elcodi.entity.manufacturer.enabled'
            );
    }
}
