<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\CoreBundle\Tests\DependencyInjection\Interfaces;

trait EntitiesOverridableExtensionInterfaceTrait
{
    public function testGetEntitiesOverrides()
    {
        $entitiesOverrides = $this->object->getEntitiesOverrides();

        $this->assertInternalType('array', $entitiesOverrides);
        $this->assertContainsOnly('string', $entitiesOverrides);

        $entities = array_keys($entitiesOverrides);
        foreach ($entities as $entity) {
            $this->assertTrue(
                interface_exists($entity, true) || class_exists($entity, true) || trait_exists($entity, true),
                sprintf("%s doesn't exist.", $entity)
            );
        }
    }
}
