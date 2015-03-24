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

namespace Elcodi\Bundle\CartBundle\CompilerPass;

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
                'elcodi.core.cart.entity.cart.manager',
                'elcodi.core.cart.entity.cart.class',
                'elcodi.core.cart.entity.cart.mapping_file',
                'elcodi.core.cart.entity.cart.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.cart.entity.cart_line.manager',
                'elcodi.core.cart.entity.cart_line.class',
                'elcodi.core.cart.entity.cart_line.mapping_file',
                'elcodi.core.cart.entity.cart_line.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.cart.entity.order.manager',
                'elcodi.core.cart.entity.order.class',
                'elcodi.core.cart.entity.order.mapping_file',
                'elcodi.core.cart.entity.order.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.cart.entity.order_line.manager',
                'elcodi.core.cart.entity.order_line.class',
                'elcodi.core.cart.entity.order_line.mapping_file',
                'elcodi.core.cart.entity.order_line.enabled'
            );
    }
}
