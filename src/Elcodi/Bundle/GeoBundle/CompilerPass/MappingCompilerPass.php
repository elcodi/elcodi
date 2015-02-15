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

namespace Elcodi\Bundle\GeoBundle\CompilerPass;

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
                'elcodi.core.geo.entity.country.manager',
                'elcodi.core.geo.entity.country.class',
                'elcodi.core.geo.entity.country.mapping_file',
                'elcodi.core.geo.entity.country.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.geo.entity.state.manager',
                'elcodi.core.geo.entity.state.class',
                'elcodi.core.geo.entity.state.mapping_file',
                'elcodi.core.geo.entity.state.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.geo.entity.province.manager',
                'elcodi.core.geo.entity.province.class',
                'elcodi.core.geo.entity.province.mapping_file',
                'elcodi.core.geo.entity.province.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.geo.entity.city.manager',
                'elcodi.core.geo.entity.city.class',
                'elcodi.core.geo.entity.city.mapping_file',
                'elcodi.core.geo.entity.city.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.geo.entity.postal_code.manager',
                'elcodi.core.geo.entity.postal_code.class',
                'elcodi.core.geo.entity.postal_code.mapping_file',
                'elcodi.core.geo.entity.postal_code.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.geo.entity.address.manager',
                'elcodi.core.geo.entity.address.class',
                'elcodi.core.geo.entity.address.mapping_file',
                'elcodi.core.geo.entity.address.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.entity.location.manager',
                'elcodi.entity.location.class',
                'elcodi.entity.location.mapping_file',
                'elcodi.entity.location.enabled'
            );
    }
}
