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

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits as CoreTraits;
use Elcodi\Component\Media\Tests\Entity\Traits as MediaTraits;
use Elcodi\Component\Product\Entity\Manufacturer;

class ManufacturerTest extends PHPUnit_Framework_TestCase
{
    use CoreTraits\IdentifiableTrait,
        CoreTraits\DateTimeTrait,
        CoreTraits\EnabledTrait,
        MediaTraits\PrincipalImageTrait;

    /**
     * @var Manufacturer
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Manufacturer();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testDescription()
    {
        $description = sha1(rand());

        $setterOutput = $this->object->setDescription($description);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDescription();
        $this->assertSame($description, $getterOutput);
    }

    public function testSlug()
    {
        $slug = sha1(rand());

        $setterOutput = $this->object->setSlug($slug);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSlug();
        $this->assertSame($slug, $getterOutput);
    }

    public function testProducts()
    {
        $e1 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $e2 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setProducts($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getProducts();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface',
            $getterOutput
        );

        $adderOutput = $this->object->addProduct($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getProducts();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface',
            $getterOutput
        );

        $removerOutput = $this->object->removeProduct($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getProducts();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface',
            $getterOutput
        );

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testToString()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame($name, (string) $this->object);
    }
}
