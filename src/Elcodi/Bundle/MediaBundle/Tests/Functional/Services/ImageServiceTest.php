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

namespace Elcodi\Bundle\MediaBundle\Tests\Functional\Services;

use Symfony\Component\HttpFoundation\File\File;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Class ImageServiceTest.
 */
class ImageServiceTest extends WebTestCase
{
    /**
     * Test image object creation.
     */
    public function testCreateImage()
    {
        $imagePath = realpath(dirname(__FILE__)) . '/images/image-10-10.gif';
        $file = new File($imagePath);

        /**
         * @var ImageInterface $image
         */
        $image = $this
            ->get('elcodi.manager.media_image')
            ->createImage($file);

        $this->assertInstanceOf('Elcodi\Component\Media\Entity\Interfaces\ImageInterface', $image);
        $this->assertEquals($image->getWidth(), 10);
        $this->assertEquals($image->getHeight(), 10);
        $this->assertEquals($image->getContentType(), 'image/gif');
        $this->assertEquals($image->getExtension(), 'gif');
        $this->assertEquals($image->getSize(), 102);
    }
}
