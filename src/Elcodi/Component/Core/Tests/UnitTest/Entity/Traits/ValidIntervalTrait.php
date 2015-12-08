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

namespace Elcodi\Component\Core\Tests\UnitTest\Entity\Traits;

trait ValidIntervalTrait
{
    public function testValidFrom()
    {
        $validFrom = new \DateTime();

        $setterOutput = $this->object->setValidFrom($validFrom);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getValidFrom();
        $this->assertSame($validFrom, $getterOutput);
    }

    public function testValidTo()
    {
        $validTo = new \DateTime();

        $setterOutput = $this->object->setvalidTo($validTo);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getvalidTo();
        $this->assertSame($validTo, $getterOutput);
    }
}
