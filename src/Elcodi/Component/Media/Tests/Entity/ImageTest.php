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

namespace Elcodi\Component\Media\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Media\Entity\Image;

class ImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Image
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Image();
    }

    public function testWidth()
    {
        $width = rand();

        $setterOutput = $this->object->setWidth($width);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getWidth();
        $this->assertSame($width, $getterOutput);
    }

    public function testHeight()
    {
        $height = rand();

        $setterOutput = $this->object->setHeight($height);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getHeight();
        $this->assertSame($height, $getterOutput);
    }
}
