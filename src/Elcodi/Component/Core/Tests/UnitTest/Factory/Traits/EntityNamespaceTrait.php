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

namespace Elcodi\Component\Core\Tests\UnitTest\Factory\Traits;

trait EntityNamespaceTrait
{
    public function testEntityNamespace()
    {
        $entityNamespace = sha1(rand());

        $setterOutput = $this->object->setEntityNamespace($entityNamespace);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEntityNamespace();
        $this->assertSame($entityNamespace, $getterOutput);
    }
}
