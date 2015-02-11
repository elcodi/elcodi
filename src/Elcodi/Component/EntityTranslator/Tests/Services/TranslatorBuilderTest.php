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

use Elcodi\Component\EntityTranslator\Services\EntityTranslatorBuilder;

/**
 * Class TranslatorBuilderTest
 */
class TranslatorBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test compilation ok
     */
    public function testCompileOk()
    {
        $entityTranslationProvider = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider', array(), array(), '', false);
        $translatorFactory = $this->getMock('Elcodi\Component\EntityTranslator\Factory\EntityTranslatorFactory', array(), array(), '', false);
        $translator = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslator', array(), array(), '', false);

        $translatorFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($translator));

        $configuration = array(
            'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                'alias'    => 'product',
                'idGetter' => 'getId',
                'fields'   => array(
                    'name' => array(
                        'setter' => 'setName',
                        'getter' => 'getName',
                    ),
                ),
            ),
        );

        $translatorBuilder = new EntityTranslatorBuilder(
            $entityTranslationProvider,
            $translatorFactory,
            $configuration
        );
        $translator = $translatorBuilder->compile();
        $this->assertInstanceOf('\Elcodi\Component\EntityTranslator\Services\EntityTranslator', $translator);
    }

    /**
     * Test compilation fail
     *
     * @dataProvider dataCompileException
     * @expectedException \Elcodi\Component\EntityTranslator\Exception\TranslationDefinitionException
     */
    public function testCompileException($configuration)
    {
        $entityTranslationProvider = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider', array(), array(), '', false);
        $translatorFactory = $this->getMock('Elcodi\Component\EntityTranslator\Factory\EntityTranslatorFactory', array(), array(), '', false);

        $translatorBuilder = new EntityTranslatorBuilder(
            $entityTranslationProvider,
            $translatorFactory,
            $configuration
        );
        $translatorBuilder->compile();
    }

    /**
     * data testCompileException
     */
    public function dataCompileException()
    {
        return [
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\NonExistingProduct' => array(
                        'alias'    => 'product',
                        'getterId' => 'getId',
                        'fields'   => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'getName',
                            ),
                        ),
                    ),
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'    => 'product',
                        'getterId' => 'nonExistingGetId',
                        'fields'   => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'getName',
                            ),
                        ),
                    ),
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => '',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'getName',
                            ),
                        ),
                    ),
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => 'product',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'nonExistingSetName',
                                'getter' => 'getName',
                            ),
                        ),
                    ),
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => 'product',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'nonExistingGetName',
                            ),
                        ),
                    ),
                ],
            ],
        ];
    }
}
