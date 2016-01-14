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

namespace Elcodi\Component\Core\Tests\UnitTest\Encoder;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Encoder\PHPEncoder;

/**
 * Class PHPEncoderTest.
 */
class PHPEncoderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test json encode.
     *
     * @dataProvider dataEncodeDecode
     */
    public function testEncode($data, $dataEncoded)
    {
        $encoder = new PHPEncoder();

        $this->assertEquals(
            $encoder->encode($data),
            $dataEncoded
        );
    }

    /**
     * Test json decode.
     *
     * @dataProvider dataEncodeDecode
     */
    public function testDecode($data, $dataEncoded)
    {
        $encoder = new PHPEncoder();

        $this->assertEquals(
            $encoder->decode($dataEncoded),
            $data
        );
    }

    /**
     * data provider for json encode.
     */
    public function dataEncodeDecode()
    {
        return [
            [null, 'N;'],
            [true, 'b:1;'],
            [false, 'b:0;'],
            ['foo', 's:3:"foo";'],
            [['foo'], 'a:1:{i:0;s:3:"foo";}'],
            ['', 's:0:"";'],
        ];
    }
}
