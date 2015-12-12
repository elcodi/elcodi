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

trait FactoryTrait
{
    public function testFactory()
    {
        $abstractFactory = $this->getMock('Elcodi\Component\Core\Factory\Abstracts\AbstractFactory');

        $setterOutput = $this->object->setFactory($abstractFactory);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getFactory();
        $this->assertSame($abstractFactory, $getterOutput);
    }
}
