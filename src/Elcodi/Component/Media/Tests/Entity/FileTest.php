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

use Elcodi\Component\Media\Entity\File;

class FileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var File
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new File();
    }

    public function testPath()
    {
        $path = sha1(rand());

        $setterOutput = $this->object->setPath($path);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPath();
        $this->assertSame($path, $getterOutput);
    }

    public function testContentType()
    {
        $contentType = sha1(rand());

        $setterOutput = $this->object->setContentType($contentType);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getContentType();
        $this->assertSame($contentType, $getterOutput);
    }

    public function testExtension()
    {
        $extension = sha1(rand());

        $setterOutput = $this->object->setExtension($extension);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getExtension();
        $this->assertSame($extension, $getterOutput);
    }

    public function testSize()
    {
        $size = rand();

        $setterOutput = $this->object->setSize($size);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSize();
        $this->assertSame($size, $getterOutput);
    }

    public function testContent()
    {
        $content = sha1(rand());

        $setterOutput = $this->object->setContent($content);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getContent();
        $this->assertSame($content, $getterOutput);
    }
}
