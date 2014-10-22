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

namespace Elcodi\Bundle\UserBundle\CompilerPass;

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
                'elcodi.core.user.entity.abstract_user.manager',
                'elcodi.core.user.entity.abstract_user.class',
                'elcodi.core.user.entity.abstract_user.mapping_file',
                'elcodi.core.user.entity.abstract_user.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.user.entity.admin_user.manager',
                'elcodi.core.user.entity.admin_user.class',
                'elcodi.core.user.entity.admin_user.mapping_file',
                'elcodi.core.user.entity.admin_user.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.user.entity.customer.manager',
                'elcodi.core.user.entity.customer.class',
                'elcodi.core.user.entity.customer.mapping_file',
                'elcodi.core.user.entity.customer.enabled'
            );
    }
}
