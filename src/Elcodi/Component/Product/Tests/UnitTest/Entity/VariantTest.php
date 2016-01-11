<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Product\Tests\UnitTest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Attribute\Entity\Attribute;
use Elcodi\Component\Attribute\Entity\Value;
use Elcodi\Component\Product\Entity\Product;
use Elcodi\Component\Product\Entity\Variant;

/**
 * Class VariantTest.
 */
class VariantTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that the addOption method has no side effects on
     * parent Product Attribute collection.
     *
     * In fact this is sort of a "compound" test, since we are
     * checking the expected behavior by looking in the parent
     * Product Attribute list
     */
    public function testAddOption()
    {
        $attribute1 = new Attribute();

        $option1 = new Value();
        $option1->setAttribute($attribute1);

        $option2 = new Value();
        $option2->setAttribute($attribute1);

        $attribute2 = new Attribute();

        $option3 = new Value();
        $option3->setAttribute($attribute2);

        /**
         * @var Product $product
         */
        $product = $this->getMock('Elcodi\Component\Product\Entity\Product', null);
        $product->setAttributes(new ArrayCollection());

        /**
         * @var Variant $variant
         */
        $variant = $this->getMock('Elcodi\Component\Product\Entity\Variant', null);
        $variant->setProduct($product);
        $variant->setOptions(new ArrayCollection());

        $variant->addOption($option1);

        $this->assertEquals(
            $attribute1,
            $product->getAttributes()->first()
        );

        $this->assertProductAttributeCollectionSizeIs($product, 1);

        /*
         * $option2 has Attribute $attribute1, so
         * no new Attribute should be added to parent
         * product Attribute Collection
         */
        $variant->addOption($option2);
        $this->assertProductAttributeCollectionSizeIs($product, 1);

        /*
         * $option3 has Attribute $attribute2 which has to
         * be added to Product Attribute collection. Count
         * must be 2
         */
        $variant->addOption($option3);
        $this->assertProductAttributeCollectionSizeIs($product, 2);
    }

    /**
     * Tests that adding an option to a Variant with no
     * configured parent Product throws a LogicException.
     *
     * @expectedException \LogicException
     */
    public function testAddOptionThrowsLogicException()
    {
        /**
         * @var Variant $variant
         */
        $variant = $this->getMock('Elcodi\Component\Product\Entity\Variant', null);
        $variant->addOption(new Value());
    }

    /**
     * Shortcut method to assert product Attribute collection size.
     *
     * @param Product $product
     * @param         $size
     */
    private function assertProductAttributeCollectionSizeIs(Product $product, $size)
    {
        $this->assertEquals(
            $size,
            $product->getAttributes()->count()
        );
    }

    /**
     * Dataprovider for testSetOptions.
     *
     * @param ArrayCollection $options              Option collection to be tested
     * @param int             $count                Number of expected items in the collection
     * @param bool            $initializeCollection whether to initialize the Option collection
     *
     * @dataProvider dataSetOptions
     */
    public function testSetOptions($options, $count, $initializeCollection)
    {
        /**
         * @var Product $product
         */
        $product = $this->getMock('Elcodi\Component\Product\Entity\Product', null);
        $product->setAttributes(new ArrayCollection());

        /**
         * @var Variant $variant
         */
        $variant = $this->getMock('Elcodi\Component\Product\Entity\Variant', null);
        $variant->setProduct($product);

        if ($initializeCollection) {
            $reflectedVariantOptions = new \ReflectionProperty(
                'Elcodi\Component\Product\Entity\Variant',
                'options'
            );
            $reflectedVariantOptions->setAccessible(true);
            $reflectedVariantOptions->setValue($variant, new ArrayCollection());
        }

        $variant->setOptions($options);

        $this->assertEquals(
            $options,
            $variant->getOptions()
        );

        $this->assertEquals(
            $count,
            $variant->getOptions()->count()
        );
    }

    /**
     * Data provider for Variant::setOptions() test values.
     *
     * @return array
     */
    public function dataSetOptions()
    {
        /*
         * Array with the following items
         * - ArrayCollection of variant Options
         * - Number of expected items inside the Collection
         * - Whether to initialize or not an empty collection
         *   in the form of Variant::setOptions(new ArrayCollection)
         *
         * The third element mimics the factory of the Variant entity,
         * which we cannot use here since we are only testing the
         * setOption method
         */

        return [
            [new ArrayCollection(), 0, false],
            [new ArrayCollection(), 0, true],
            [$this->createNewOptionCollection(1), 1, true],
            [$this->createNewOptionCollection(2), 2, true],
            [$this->createNewOptionCollection(3), 3, true],
            [$this->createNewOptionCollection(1, new Attribute()), 1, true],
            [$this->createNewOptionCollection(2, new Attribute()), 2, true],
            [$this->createNewOptionCollection(3, new Attribute()), 3, true],
        ];
    }

    /**
     * Shortcut for creating a new Value / Attribute.
     *
     * @param int       $size      Collection size
     * @param Attribute $attribute Whether to use an existing Attribute for the Options
     *
     * @return ArrayCollection
     */
    private function createNewOptionCollection($size = 1, Attribute $attribute = null)
    {
        if (is_null($attribute)) {
            $attribute = new Attribute();
        }

        $optionCollection = new ArrayCollection();

        while ($size--) {
            $option = new Value();
            $option->setAttribute($attribute);

            $optionCollection->add($option);
        }

        return $optionCollection;
    }
}
