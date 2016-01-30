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

namespace Elcodi\Component\Media\Tests\UnitTest\Adapter\Model;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Media\Adapter\Resizer\Model\Dimensions;
use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class DimensionsTest.
 */
class DimensionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test dimensions.
     *
     * working with an image with dimensions 400x400
     */
    public function testDimensionsNoResize()
    {
        $dimensions = Dimensions::create(
            400,
            400,
            200,
            200,
            ElcodiMediaImageResizeTypes::NO_RESIZE
        );

        $this->assertEquals(0, $dimensions->getSrcX());
        $this->assertEquals(0, $dimensions->getSrcY());
        $this->assertEquals(400, $dimensions->getSrcWidth());
        $this->assertEquals(400, $dimensions->getSrcHeight());

        $this->assertEquals(0, $dimensions->getDstX());
        $this->assertEquals(0, $dimensions->getDstY());
        $this->assertEquals(400, $dimensions->getDstWidth());
        $this->assertEquals(400, $dimensions->getDstHeight());
        $this->assertEquals(400, $dimensions->getDstFrameX());
        $this->assertEquals(400, $dimensions->getDstFrameY());
    }

    /**
     * Test dimensions.
     *
     * working with an image with dimensions 400x400
     */
    public function testDimensionsForceMesasures()
    {
        $dimensions = Dimensions::create(
            400,
            400,
            200,
            200,
            ElcodiMediaImageResizeTypes::FORCE_MEASURES
        );

        $this->assertEquals(0, $dimensions->getSrcX());
        $this->assertEquals(0, $dimensions->getSrcY());
        $this->assertEquals(400, $dimensions->getSrcWidth());
        $this->assertEquals(400, $dimensions->getSrcHeight());

        $this->assertEquals(0, $dimensions->getDstX());
        $this->assertEquals(0, $dimensions->getDstY());
        $this->assertEquals(200, $dimensions->getDstWidth());
        $this->assertEquals(200, $dimensions->getDstHeight());
        $this->assertEquals(200, $dimensions->getDstFrameX());
        $this->assertEquals(200, $dimensions->getDstFrameY());
    }

    /**
     * Test dimensions.
     *
     * working with an image with dimensions 400x400
     */
    public function testDimensionsInset()
    {
        $dimensions = Dimensions::create(
            400,
            400,
            300,
            150,
            ElcodiMediaImageResizeTypes::INSET
        );

        $this->assertEquals(0, $dimensions->getSrcX());
        $this->assertEquals(0, $dimensions->getSrcY());
        $this->assertEquals(400, $dimensions->getSrcWidth());
        $this->assertEquals(400, $dimensions->getSrcHeight());

        $this->assertEquals(0, $dimensions->getDstX());
        $this->assertEquals(0, $dimensions->getDstY());
        $this->assertEquals(150, $dimensions->getDstWidth());
        $this->assertEquals(150, $dimensions->getDstHeight());
        $this->assertEquals(150, $dimensions->getDstFrameX());
        $this->assertEquals(150, $dimensions->getDstFrameY());
    }

    /**
     * Test dimensions.
     *
     * working with an image with dimensions 400x400
     */
    public function testDimensionsInsetFillWhite()
    {
        $dimensions = Dimensions::create(
            400,
            400,
            300,
            150,
            ElcodiMediaImageResizeTypes::INSET_FILL_WHITE
        );

        $this->assertEquals(0, $dimensions->getSrcX());
        $this->assertEquals(0, $dimensions->getSrcY());
        $this->assertEquals(400, $dimensions->getSrcWidth());
        $this->assertEquals(400, $dimensions->getSrcHeight());

        $this->assertEquals(75, $dimensions->getDstX());
        $this->assertEquals(0, $dimensions->getDstY());
        $this->assertEquals(150, $dimensions->getDstWidth());
        $this->assertEquals(150, $dimensions->getDstHeight());
        $this->assertEquals(300, $dimensions->getDstFrameX());
        $this->assertEquals(150, $dimensions->getDstFrameY());
    }

    /**
     * Test dimensions.
     *
     * working with an image with dimensions 400x400
     */
    public function testDimensionsOutboundsFillWhite()
    {
        $dimensions = Dimensions::create(
            400,
            400,
            300,
            150,
            ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE
        );

        $this->assertEquals(0, $dimensions->getSrcX());
        $this->assertEquals(0, $dimensions->getSrcY());
        $this->assertEquals(400, $dimensions->getSrcWidth());
        $this->assertEquals(400, $dimensions->getSrcHeight());

        $this->assertEquals(0, $dimensions->getDstX());
        $this->assertEquals(0, $dimensions->getDstY());
        $this->assertEquals(300, $dimensions->getDstWidth());
        $this->assertEquals(300, $dimensions->getDstHeight());
        $this->assertEquals(300, $dimensions->getDstFrameX());
        $this->assertEquals(300, $dimensions->getDstFrameY());
    }

    /**
     * Test dimensions.
     *
     * working with an image with dimensions 400x400
     */
    public function testDimensionsOutboundsCrop()
    {
        $dimensions = Dimensions::create(
            450,
            450,
            300,
            150,
            ElcodiMediaImageResizeTypes::OUTBOUND_CROP
        );

        $this->assertEquals(0, $dimensions->getSrcX());
        $this->assertEquals(112.5, $dimensions->getSrcY());
        $this->assertEquals(450, $dimensions->getSrcWidth());
        $this->assertEquals(225, $dimensions->getSrcHeight());

        $this->assertEquals(0, $dimensions->getDstX());
        $this->assertEquals(0, $dimensions->getDstY());
        $this->assertEquals(300, $dimensions->getDstWidth());
        $this->assertEquals(150, $dimensions->getDstHeight());
        $this->assertEquals(300, $dimensions->getDstFrameX());
        $this->assertEquals(150, $dimensions->getDstFrameY());
    }
}
