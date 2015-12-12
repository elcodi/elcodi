<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Media\Tests\Adapter\Resizer;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Media\Adapter\Resizer\ImageMagickResizeAdapter;

class ImageMagickResizeAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ImageMagickResizeAdapter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        // $this->object = new ImageMagickResizeAdapter();
    }

    public function testResize()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
