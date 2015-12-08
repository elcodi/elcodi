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

namespace Elcodi\Component\Rule\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Rule\Entity\Rule;

class RuleTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    /**
     * @var Rule
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Rule();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testExpression()
    {
        $expression = sha1(rand());

        $setterOutput = $this->object->setExpression($expression);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getExpression();
        $this->assertSame($expression, $getterOutput);
    }
}
