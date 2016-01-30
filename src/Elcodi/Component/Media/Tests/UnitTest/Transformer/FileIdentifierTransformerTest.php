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

use Elcodi\Component\Media\Transformer\FileIdentifierTransformer;

/**
 * Class FileIdentifierTransformerTest.
 */
class FileIdentifierTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test image etag generator.
     */
    public function testGetEtag()
    {
        $imageEtagGenerator = new FileIdentifierTransformer();

        $file = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\FileInterface');
        $file
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('2'));
        $file
            ->expects($this->any())
            ->method('getExtension')
            ->will($this->returnValue('png'));

        $this->assertEquals(
            '2.png',
            $imageEtagGenerator->transform($file)
        );
    }
}
