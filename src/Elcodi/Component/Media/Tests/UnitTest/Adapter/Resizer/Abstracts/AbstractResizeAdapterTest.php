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

namespace Elcodi\Component\Media\Tests\UnitTest\Adapter\Resizer\Abstracts;

use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\File\File;

use Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class AbstractResizeAdapterTest.
 *
 * @ignore
 */
abstract class AbstractResizeAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Return instance of resizeAdapter.
     *
     * @return ResizeAdapterInterface Resize Adapter
     */
    abstract public function getAdapterInstance();

    /**
     * Test adapter resize action.
     *
     * @dataProvider dataResize
     */
    public function testResize(
        $originalHeight,
        $originalWidth,
        $type,
        $definedHeight,
        $definedWidth,
        $expectedHeight,
        $expectedWidth
    ) {
        $imagePath = tempnam(sys_get_temp_dir(), '_test');
        $image = imagecreate($originalWidth, $originalHeight);
        $background = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $originalWidth, $originalHeight, $background);
        imagejpeg($image, $imagePath, 100);
        $imageData = file_get_contents($imagePath);

        $convertedImageData = $this
            ->getAdapterInstance()
            ->resize($imageData, $definedHeight, $definedWidth, $type);

        $this->assertNotEmpty($convertedImageData);
        $resizedImagePath = tempnam(sys_get_temp_dir(), '_test');
        $temporaryFile = new File($resizedImagePath);
        file_put_contents($temporaryFile, $convertedImageData);
        list($width, $height) = getimagesize($temporaryFile);

        $this->assertEquals($expectedHeight, $height);
        $this->assertEquals($expectedWidth, $width);
        unlink($imagePath);
        unlink($resizedImagePath);
    }

    /**
     * Data for testResize.
     */
    public function dataResize()
    {
        return [
            [100, 120, ElcodiMediaImageResizeTypes::NO_RESIZE, 50, 50, 100, 120],
            [100, 120, ElcodiMediaImageResizeTypes::FORCE_MEASURES, 50, 30, 50, 30],
            [100, 120, ElcodiMediaImageResizeTypes::INSET, 50, 30, 25, 30],
            [100, 120, ElcodiMediaImageResizeTypes::INSET_FILL_WHITE, 50, 30, 50, 30],
            [100, 120, ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE, 60, 75, 60, 72],
            [100, 120, ElcodiMediaImageResizeTypes::OUTBOUND_CROP, 50, 30, 50, 30],
        ];
    }
}
