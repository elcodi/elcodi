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

namespace Elcodi\Bundle\ShippingBundle\CompilerPass;

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
                'elcodi.entity.warehouse.manager',
                'elcodi.entity.warehouse.class',
                'elcodi.entity.warehouse.mapping_file',
                'elcodi.entity.warehouse.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.entity.shipping_range.manager',
                'elcodi.entity.shipping_range.class',
                'elcodi.entity.shipping_range.mapping_file',
                'elcodi.entity.shipping_range.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.entity.carrier.manager',
                'elcodi.entity.carrier.class',
                'elcodi.entity.carrier.mapping_file',
                'elcodi.entity.carrier.enabled'
            );
    }
}
