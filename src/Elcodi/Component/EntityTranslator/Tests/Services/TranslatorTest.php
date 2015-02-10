<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
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

namespace Elcodi\Component\EntityTranslator\Tests\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\EntityTranslator\Services\EntityTranslator;
use Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct;

/**
 * Class TranslatorTest
 */
class TranslatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test translate
     */
    public function testTranslate()
    {
        $entityTranslationProvider = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider', array(), array(), '', false);
        $entityTranslationProvider
            ->expects($this->once())
            ->method('getTranslation')
            ->with(
                $this->equalTo('product'),
                $this->equalTo('1'),
                $this->equalTo('name'),
                $this->equalTo('en')
            )
            ->will($this->returnValue('translatedProductName'));

        $configuration = array(
            'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                'alias'    => 'product',
                'idGetter' => 'getId',
                'fields'   => array(
                    'name' => array(
                        'setter' => 'setName',
                        'getter' => 'getName',
                    )
                )
            ),
        );

        $translator = new EntityTranslator(
            $entityTranslationProvider,
            $configuration
        );

        $product = new TranslatableProduct();
        $product
            ->setId(1)
            ->setName('productName');

        $translatedProduct = $translator->translate($product, 'en');
        $this->assertSame($product, $translatedProduct);
        $this->assertEquals('translatedProductName', $translatedProduct->getName());
    }

    /**
     * Test the save method
     */
    public function testSave()
    {
        $entityTranslationProvider = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider', array(), array(), '', false);
        $entityTranslationProvider
            ->expects($this->exactly(4))
            ->method('setTranslation')
            ->withConsecutive(array(
                $this->equalTo('product'),
                $this->equalTo('1'),
                $this->equalTo('name'),
                $this->equalTo('el nombre'),
                $this->equalTo('es')
            ), array(
                $this->equalTo('product'),
                $this->equalTo('1'),
                $this->equalTo('description'),
                $this->equalTo('la descripción'),
                $this->equalTo('es')
            ), array(
                $this->equalTo('product'),
                $this->equalTo('1'),
                $this->equalTo('name'),
                $this->equalTo('the name'),
                $this->equalTo('en')
            ), array(
                $this->equalTo('product'),
                $this->equalTo('1'),
                $this->equalTo('description'),
                $this->equalTo('the description'),
                $this->equalTo('en')
            ));

        $entityTranslationProvider
            ->expects($this->once())
            ->method('flushTranslations');

        $configuration = array(
            'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                'alias'    => 'product',
                'idGetter' => 'getId',
                'fields'   => array(
                    'name'        => array(
                        'setter' => 'setName',
                        'getter' => 'getName',
                    ),
                    'description' => array(
                        'setter' => 'setDescription',
                        'getter' => 'getDescription',
                    )
                )
            ),
        );

        $translator = new EntityTranslator(
            $entityTranslationProvider,
            $configuration
        );

        $product = new TranslatableProduct();
        $product
            ->setId(1)
            ->setName('wrong name')
            ->setDescription('wrong description');

        $translator->save($product, array(
            'es' => array(
                'name'        => 'el nombre',
                'description' => 'la descripción',
            ),
            'en' => array(
                'name'         => 'the name',
                'description'  => 'the description',
                'anotherfield' => 'some value',
            ),
        ));
    }
}
