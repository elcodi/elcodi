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

namespace Elcodi\Bundle\CartCouponBundle\CompilerPass;

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
                'elcodi.core.cart_coupon.entity.cart_coupon.manager',
                'elcodi.core.cart_coupon.entity.cart_coupon.class',
                'elcodi.core.cart_coupon.entity.cart_coupon.mapping_file',
                'elcodi.core.cart_coupon.entity.cart_coupon.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.cart_coupon.entity.order_coupon.manager',
                'elcodi.core.cart_coupon.entity.order_coupon.class',
                'elcodi.core.cart_coupon.entity.order_coupon.mapping_file',
                'elcodi.core.cart_coupon.entity.order_coupon.enabled'
            );
    }
}
