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

namespace Elcodi\Component\Media\Tests\UnitTest\Adapter\Resizer;

use Elcodi\Component\Media\Adapter\Resizer\ImageMagickResizeAdapter;
use Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\Component\Media\Tests\UnitTest\Adapter\Resizer\Abstracts\AbstractResizeAdapterTest;

/**
 * Class ImageMagickResizeAdapterTest
 */
class ImageMagickResizeAdapterTest extends AbstractResizeAdapterTest
{
    /**
     * Return instance of resizeAdapter
     *
     * @return ResizeAdapterInterface Resize Adapter
     */
    public function getAdapterInstance()
    {
        return new ImageMagickResizeAdapter(
            '/usr/bin/convert',
            '/usr/share/color/icc/colord/sRGB.icc'
        );
    }
}
