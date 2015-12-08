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

namespace Elcodi\Component\Page\Tests\Entity;

use DateTime;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Page\Entity\Page;

/**
 * Class PageTest.
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 * @author Berny Cantos <be@rny.cc>
 */
class PageTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait, Traits\EnabledTrait;

    /**
     * @var Page
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Page();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testPath()
    {
        $path = sha1(rand());

        $setterOutput = $this->object->setPath($path);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPath();
        $this->assertSame($path, $getterOutput);
    }

    public function testTitle()
    {
        $title = sha1(rand());

        $setterOutput = $this->object->setTitle($title);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getTitle();
        $this->assertSame($title, $getterOutput);
    }

    public function testContent()
    {
        $content = sha1(rand());

        $setterOutput = $this->object->setContent($content);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getContent();
        $this->assertSame($content, $getterOutput);
    }

    public function testType()
    {
        $type = rand();

        $setterOutput = $this->object->setType($type);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getType();
        $this->assertSame($type, $getterOutput);
    }

    public function testPersistent()
    {
        $persistent = (bool) rand(0, 1);

        $setterOutput = $this->object->setPersistent($persistent);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->isPersistent();
        $this->assertSame($persistent, $getterOutput);
    }
}
