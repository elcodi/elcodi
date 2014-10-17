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
                'elcodi.core.shipping.entity.warehouse.manager',
                'elcodi.core.shipping.entity.warehouse.class',
                'elcodi.core.shipping.entity.warehouse.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.shipping.entity.carrier_range.manager',
                'elcodi.core.shipping.entity.carrier_range.class',
                'elcodi.core.shipping.entity.carrier_range.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.shipping.entity.carrier_price_range.manager',
                'elcodi.core.shipping.entity.carrier_price_range.class',
                'elcodi.core.shipping.entity.carrier_price_range.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.shipping.entity.carrier_weight_range.manager',
                'elcodi.core.shipping.entity.carrier_weight_range.class',
                'elcodi.core.shipping.entity.carrier_weight_range.mapping_file'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.shipping.entity.carrier.manager',
                'elcodi.core.shipping.entity.carrier.class',
                'elcodi.core.shipping.entity.carrier.mapping_file'
            );
    }
}
