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

namespace Elcodi\Component\Media\Tests\UnitTest\Transformer;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Media\Transformer\ImageEtagTransformer;

/**
 * Class ImageEtagTransformerTest.
 */
class ImageEtagTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test image etag generator.
     */
    public function testGetEtag()
    {
        $imageEtagGenerator = new ImageEtagTransformer();
        $dateTime = $this->getMock('DateTime');
        $dateTime
            ->expects($this->any())
            ->method('getTimestamp')
            ->will($this->returnValue('123456'));

        $image = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');
        $image
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('2'));
        $image
            ->expects($this->any())
            ->method('getUpdatedAt')
            ->will($this->returnValue($dateTime));

        $this->assertEquals(
            '5c5253c90e9fc68a8b2be2b78313689e16b1d683',
            $imageEtagGenerator->transform($image, 50, 60, 2)
        );
    }
}
