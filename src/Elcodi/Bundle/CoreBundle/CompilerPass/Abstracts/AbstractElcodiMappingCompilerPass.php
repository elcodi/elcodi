<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\CoreBundle\CompilerPass\Abstracts;

use Mmoreram\SimpleDoctrineMapping\CompilerPass\Abstracts\AbstractMappingCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AbstractElcodiMappingCompilerPass.
 */
abstract class AbstractElcodiMappingCompilerPass extends AbstractMappingCompilerPass
{
    /**
     * Add entity mapping given the entity name, given that all entity
     * definitions are built the same way and given as well that the method
     * addEntityMapping exists and is accessible.
     *
     * @param ContainerBuilder $container Container
     * @param array            $entities  Name of the entities
     *
     * @return $this Self object
     */
    protected function addEntityMappings(
        ContainerBuilder $container,
        array $entities
    ) {
        foreach ($entities as $entity) {
            $this
                ->addEntityMapping(
                    $container,
                    'elcodi.entity.' . $entity . '.manager',
                    'elcodi.entity.' . $entity . '.class',
                    'elcodi.entity.' . $entity . '.mapping_file',
                    'elcodi.entity.' . $entity . '.enabled'
                );
        }

        return $this;
    }
}
