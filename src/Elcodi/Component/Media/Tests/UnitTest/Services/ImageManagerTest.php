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
use Symfony\Component\HttpFoundation\File\File;

use Elcodi\Component\Media\Entity\Image;
use Elcodi\Component\Media\Services\ImageManager;

/**
 * Class ImageManagerTest.
 */
class ImageManagerTest extends PHPUnit_Framework_TestCase
{
    /** @var ImageManager */
    protected $imageManager;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        $mockImageFactory = $this
            ->getMockBuilder('Elcodi\Component\Media\Factory\ImageFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $mockImageFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnValue(new Image()));

        $mockFileManager = $this
            ->getMockBuilder('Elcodi\Component\Media\Services\FileManager')
            ->disableOriginalConstructor()
            ->getMock();

        $mockResizeAdapter = $this->getMock(
            'Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface'
        );

        $imageManager = new ImageManager(
            $mockImageFactory,
            $mockFileManager,
            $mockResizeAdapter
        );

        $this->imageManager = $imageManager;
    }

    /**
     * Test image etag generator.
     *
     * @dataProvider regularImagesProvider
     */
    public function testCreateImages($imagePath)
    {
        $imageFile = new File($imagePath);
        $this->assertInstanceOf(
            'Elcodi\Component\Media\Entity\Interfaces\ImageInterface',
            $this->imageManager->createImage($imageFile)
        );
    }

    /**
     * @param $imageFileObject
     * @param $finalMimeType
     *
     * @dataProvider imagesAsOctetStreamProvider
     */
    public function testCreateImagesFromApplicationOctetStream(
        File $imageFileObject,
        $finalMimeType
    ) {
        $this->assertEquals('application/octet-stream', $imageFileObject->getMimeType());
        $image = $this->imageManager->createImage($imageFileObject);

        $this->assertInstanceOf(
            'Elcodi\Component\Media\Entity\Interfaces\ImageInterface',
            $image
        );
        $this->assertEquals($finalMimeType, $image->getContentType());
    }

    /**
     * Regular images provider for tests.
     *
     * @return array
     */
    public function regularImagesProvider()
    {
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR;
        $imageJpeg = imagecreate(1, 1);
        $white = imagecolorallocate($imageJpeg, 255, 255, 255);
        imagesetpixel($imageJpeg, 1, 1, $white);
        imagejpeg($imageJpeg, $tmpDir . 'test.jpg');
        $jpegFilePath = $tmpDir . 'test.jpg';

        $pngTransparentPixel = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3a' .
            'AAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII';
        file_put_contents($tmpDir . 'test.png', base64_decode($pngTransparentPixel));
        $pngFilePath = $tmpDir . 'test.png';

        $gifTransparentPixel = 'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw';
        file_put_contents($tmpDir . 'test.gif', base64_decode($gifTransparentPixel));
        $gifFilePath = $tmpDir . 'test.gif';

        return [
            [$jpegFilePath],
            [$pngFilePath],
            [$gifFilePath],
        ];
    }

    /**
     * Images as octet stream for tests provider.
     */
    public function imagesAsOctetStreamProvider()
    {
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR;
        $imageJpeg = imagecreate(1, 1);
        $white = imagecolorallocate($imageJpeg, 255, 255, 255);
        imagesetpixel($imageJpeg, 1, 1, $white);
        imagejpeg($imageJpeg, $tmpDir . 'test.jpg');
        $jpegFilePath = $tmpDir . 'test.jpg';

        $pngTransparentPixel = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3a' .
            'AAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII';
        file_put_contents($tmpDir . 'test.png', base64_decode($pngTransparentPixel));
        $pngFilePath = $tmpDir . 'test.png';

        $gifTransparentPixel = 'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw';
        file_put_contents($tmpDir . 'test.gif', base64_decode($gifTransparentPixel));
        $gifFilePath = $tmpDir . 'test.gif';

        $mockJpegOctet = $this
            ->getMockBuilder('Symfony\Component\HttpFoundation\File\File')
            ->setConstructorArgs([$jpegFilePath])
            ->setMethods(['getMimeType'])
            ->getMock();

        $mockJpegOctet
            ->expects($this->any())
            ->method('getMimeType')
            ->will($this->returnValue('application/octet-stream'));

        $mockPngOctet = $this
            ->getMockBuilder('Symfony\Component\HttpFoundation\File\File')
            ->setConstructorArgs([$pngFilePath])
            ->setMethods(['getMimeType'])
            ->getMock();

        $mockPngOctet
            ->expects($this->any())
            ->method('getMimeType')
            ->will($this->returnValue('application/octet-stream'));

        $mockGifOctet = $this
            ->getMockBuilder('Symfony\Component\HttpFoundation\File\File')
            ->setConstructorArgs([$gifFilePath])
            ->setMethods(['getMimeType'])
            ->getMock();

        $mockGifOctet
            ->expects($this->any())
            ->method('getMimeType')
            ->will($this->returnValue('application/octet-stream'));

        return [
            [$mockJpegOctet, 'image/jpeg'],
            [$mockPngOctet, 'image/png'],
            [$mockGifOctet, 'image/gif'],
        ];
    }
}
