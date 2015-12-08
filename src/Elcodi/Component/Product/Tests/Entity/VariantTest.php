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
use Elcodi\Component\Media\Tests\Entity\Traits as MediaTraits;
use Elcodi\Component\Product\Entity\Variant;
use Elcodi\Component\Product\Tests\Entity\Traits as ProductTraits;

class VariantTest extends PHPUnit_Framework_TestCase
{
    use CoreTraits\IdentifiableTrait,
        ProductTraits\ProductPriceTrait,
        CoreTraits\DateTimeTrait,
        CoreTraits\EnabledTrait,
        ProductTraits\DimensionsTrait,
        MediaTraits\PrincipalImageTrait;

    /**
     * @var Variant
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Variant();
    }

    public function testSku()
    {
        $sku = sha1(rand());

        $setterOutput = $this->object->setSku($sku);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSku();
        $this->assertSame($sku, $getterOutput);
    }

    public function testStock()
    {
        $stock = sha1(rand());

        $setterOutput = $this->object->setStock($stock);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getStock();
        $this->assertSame($stock, $getterOutput);
    }

    public function testOptions()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testProduct()
    {
        $product = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');

        $setterOutput = $this->object->setProduct($product);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getProduct();
        $this->assertSame($product, $getterOutput);
    }

    public function testImages()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testGetSortedImages()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testImagesSort()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
