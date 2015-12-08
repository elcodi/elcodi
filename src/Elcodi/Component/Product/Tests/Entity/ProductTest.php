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
use Elcodi\Component\MetaData\Tests\Entity\Traits as MetaDataTraits;
use Elcodi\Component\Product\Entity\Product;
use Elcodi\Component\Product\Tests\Entity\Traits as ProductTraits;

class ProductTest extends PHPUnit_Framework_TestCase
{
    use CoreTraits\IdentifiableTrait,
        CoreTraits\DateTimeTrait,
        CoreTraits\EnabledTrait,
        MediaTraits\PrincipalImageTrait,
        ProductTraits\ProductPriceTrait,
        ProductTraits\DimensionsTrait,
        MetaDataTraits\MetaDataTrait;

    /**
     * @var Product
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Product();
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

    public function testDescription()
    {
        $description = sha1(rand());

        $setterOutput = $this->object->setDescription($description);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDescription();
        $this->assertSame($description, $getterOutput);
    }

    public function testShortDescription()
    {
        $shortDescription = sha1(rand());

        $setterOutput = $this->object->setShortDescription($shortDescription);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getShortDescription();
        $this->assertSame($shortDescription, $getterOutput);
    }

    public function testCategories()
    {
        $e1 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\CategoryInterface');
        $e2 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\CategoryInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setCategories($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCategories();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\CategoryInterface',
            $getterOutput
        );

        $adderOutput = $this->object->addCategory($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getCategories();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\CategoryInterface',
            $getterOutput
        );

        $removerOutput = $this->object->removeCategory($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getCategories();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\CategoryInterface',
            $getterOutput
        );

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testPrincipalCategory()
    {
        $principalCategory = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\CategoryInterface');

        $setterOutput = $this->object->setPrincipalCategory($principalCategory);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPrincipalCategory();
        $this->assertSame($principalCategory, $getterOutput);
    }

    public function testStock()
    {
        $stock = rand();

        $setterOutput = $this->object->setStock($stock);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getStock();
        $this->assertSame($stock, $getterOutput);
    }

    public function testShowInHome()
    {
        $showInHome = (bool) rand(0, 1);

        $setterOutput = $this->object->setShowInHome($showInHome);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getShowInHome();
        $this->assertSame($showInHome, $getterOutput);
    }

    public function testManufacturer()
    {
        $manufacturer = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface');

        $setterOutput = $this->object->setManufacturer($manufacturer);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getManufacturer();
        $this->assertSame($manufacturer, $getterOutput);
    }

    public function testDimensions()
    {
        $dimensions = sha1(rand());

        $setterOutput = $this->object->setDimensions($dimensions);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDimensions();
        $this->assertSame($dimensions, $getterOutput);
    }

    public function testSku()
    {
        $sku = sha1(rand());

        $setterOutput = $this->object->setSku($sku);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSku();
        $this->assertSame($sku, $getterOutput);
    }

    public function testType()
    {
        $type = rand();

        $setterOutput = $this->object->setType($type);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getType();
        $this->assertSame($type, $getterOutput);
    }

    public function testAttributes()
    {
        $e1 = $this->getMock('Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface');
        $e2 = $this->getMock('Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setAttributes($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAttributes();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface',
            $getterOutput
        );

        $adderOutput = $this->object->addAttribute($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getAttributes();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface',
            $getterOutput
        );

        $removerOutput = $this->object->removeAttribute($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getAttributes();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface',
            $getterOutput
        );

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testVariants()
    {
        $e1 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $e2 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setVariants($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getVariants();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\VariantInterface',
            $getterOutput
        );

        $adderOutput = $this->object->addVariant($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getVariants();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Product\Entity\Interfaces\VariantInterface',
            $getterOutput
        );
    }

    public function testPrincipalVariant()
    {
        $principalVariant = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');

        $setterOutput = $this->object->setPrincipalVariant($principalVariant);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPrincipalVariant();
        $this->assertSame($principalVariant, $getterOutput);
    }

    public function testHasVariants()
    {
        $this->assertFalse($this->object->hasVariants());

        $e1 = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setVariants($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertTrue($this->object->hasVariants());
    }

    public function testToString()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame($name, (string) $this->object);
    }
}
