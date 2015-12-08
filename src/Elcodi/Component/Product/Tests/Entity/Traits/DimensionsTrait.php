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

namespace Elcodi\Component\Product\Tests\Entity\Traits;

trait DimensionsTrait
{
    public function testDepth()
    {
        $depth = rand();

        $setterOutput = $this->object->setDepth($depth);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDepth();
        $this->assertSame($depth, $getterOutput);
    }

    public function testHeight()
    {
        $height = rand();

        $setterOutput = $this->object->setHeight($height);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getHeight();
        $this->assertSame($height, $getterOutput);
    }

    public function testWeight()
    {
        $weight = rand();

        $setterOutput = $this->object->setWeight($weight);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getWeight();
        $this->assertSame($weight, $getterOutput);
    }

    public function testWidth()
    {
        $width = rand();

        $setterOutput = $this->object->setWidth($width);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getWidth();
        $this->assertSame($width, $getterOutput);
    }
}
