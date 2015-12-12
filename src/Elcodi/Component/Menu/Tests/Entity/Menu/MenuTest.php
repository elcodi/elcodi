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

namespace Elcodi\Component\Menu\Tests\Entity\Menu;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Menu\Entity\Menu\Menu;

class MenuTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Menu
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Menu();
    }

    public function testCode()
    {
        $code = sha1(rand());

        $setterOutput = $this->object->setCode($code);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCode();
        $this->assertSame($code, $getterOutput);
    }

    public function testDescription()
    {
        $description = sha1(rand());

        $setterOutput = $this->object->setDescription($description);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDescription();
        $this->assertSame($description, $getterOutput);
    }
}
