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

namespace Elcodi\Component\Media\Tests\UnitTest\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Media\Services\ImageResolver;

/**
 * Class ImageResolverTest.
 */
class ImageResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve image.
     *
     * @dataProvider dataResolveImage
     */
    public function testResolveImage(
        $implementsPrincipalImage,
        $principalImage,
        $images,
        $imageReturned
    ) {
        $imagesContainer = $implementsPrincipalImage
            ? $this->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface')
            : $this->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface');

        if ($implementsPrincipalImage) {
            $imagesContainer
                ->getPrincipalImage()
                ->willReturn($principalImage);
        }

        $imagesContainer
            ->getSortedImages()
            ->willReturn(new ArrayCollection($images));

        $imageResolver = new ImageResolver();
        $this->assertSame(
            $imageReturned,
            $imageResolver->resolveImage(
                $imagesContainer->reveal()
            )
        );
    }

    /**
     * Data for testResolveImage.
     */
    public function dataResolveImage()
    {
        $image = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        $anotherImage = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        return [
            'No implements ppal, no images at all' => [false, null, [], false],
            'No implements ppal, has images' => [false, null, [$image], $image],
            'Implements ppal, no images at all' => [true, null, [], false],
            'Implements ppal, ppal image, not images' => [true, $image, [], $image],
            'Implements ppal, ppal image, has images' => [true, $image, [$anotherImage], $image],
        ];
    }
}
