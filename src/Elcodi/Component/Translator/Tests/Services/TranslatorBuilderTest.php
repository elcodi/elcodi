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
 */

namespace Elcodi\Component\Translator\Tests\Services;

use Elcodi\Component\Translator\Services\TranslatorBuilder;
use PHPUnit_Framework_TestCase;

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
        $translationProvider = $this->getMock('Elcodi\Component\Translator\Services\TranslationProvider', array(), array(), '', false);
        $translatorFactory = $this->getMock('Elcodi\Component\Translator\Factory\TranslatorFactory', array(), array(), '', false);
        $translator = $this->getMock('Elcodi\Component\Translator\Services\Translator', array(), array(), '', false);

        $translatorFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($translator));

        $configuration = array(
            'Elcodi\Component\Translator\Tests\Fixtures\TranslatableProduct' => array(
                'alias'  => 'product',
                'idGetter' => 'getId',
                'fields' => array(
                    'name' => array(
                        'setter' => 'setName',
                        'getter' => 'getName',
                    )
                )
            ),
        );

        $translatorBuilder = new TranslatorBuilder(
            $translationProvider,
            $translatorFactory,
            $configuration
        );
        $translator = $translatorBuilder->compile();
        $this->assertInstanceOf('\Elcodi\Component\Translator\Services\Translator', $translator);
    }

    /**
     * Test compilation fail
     *
     * @dataProvider dataCompileException
     * @expectedException \Elcodi\Component\Translator\Exception\TranslationDefinitionException
     */
    public function testCompileException($configuration)
    {
        $translationProvider = $this->getMock('Elcodi\Component\Translator\Services\TranslationProvider', array(), array(), '', false);
        $translatorFactory = $this->getMock('Elcodi\Component\Translator\Factory\TranslatorFactory', array(), array(), '', false);

        $translatorBuilder = new TranslatorBuilder(
            $translationProvider,
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
                    'Elcodi\Component\Translator\Tests\Fixtures\NonExistingProduct' => array(
                        'alias'  => 'product',
                        'getterId' => 'getId',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'getName',
                            )
                        )
                    )
                ]
            ],
            [
                [
                    'Elcodi\Component\Translator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => 'product',
                        'getterId' => 'nonExistingGetId',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'getName',
                            )
                        )
                    )
                ]
            ],
            [
                [
                    'Elcodi\Component\Translator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => '',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'getName',
                            )
                        )
                    )
                ]
            ],
            [
                [
                    'Elcodi\Component\Translator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => 'product',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'nonExistingSetName',
                                'getter' => 'getName',
                            )
                        )
                    )
                ]
            ],
            [
                [
                    'Elcodi\Component\Translator\Tests\Fixtures\TranslatableProduct' => array(
                        'alias'  => 'product',
                        'fields' => array(
                            'name' => array(
                                'setter' => 'setName',
                                'getter' => 'nonExistingGetName',
                            )
                        )
                    )
                ]
            ],
        ];
    }
}
