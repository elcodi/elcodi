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

namespace Elcodi\Component\Product\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits as CoreTraits;
use Elcodi\Component\MetaData\Tests\Entity\Traits as MetaDataTraits;
use Elcodi\Component\Product\Entity\Category;

class CategoryTest extends PHPUnit_Framework_TestCase
{
    use CoreTraits\IdentifiableTrait,
        CoreTraits\DateTimeTrait,
        CoreTraits\EnabledTrait,
        MetaDataTraits\MetaDataTrait;

    /**
     * @var Category
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Category();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testSlug()
    {
        $slug = sha1(rand());

        $setterOutput = $this->object->setSlug($slug);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSlug();
        $this->assertSame($slug, $getterOutput);
    }

    public function testSubCategories()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testProducts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testRoot()
    {
        $root = (bool) rand(0, 1);

        $setterOutput = $this->object->setRoot($root);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->isRoot();
        $this->assertSame($root, $getterOutput);
    }

    public function testPosition()
    {
        $position = rand();

        $setterOutput = $this->object->setPosition($position);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPosition();
        $this->assertSame($position, $getterOutput);
    }

    public function testToString()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame($name, (string) $this->object);
    }
}
