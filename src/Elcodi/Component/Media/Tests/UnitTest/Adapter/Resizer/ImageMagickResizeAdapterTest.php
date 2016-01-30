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

namespace Elcodi\Component\Media\Tests\UnitTest\Adapter\Resizer;

use Elcodi\Component\Media\Adapter\Resizer\ImageMagickResizeAdapter;
use Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\Component\Media\Tests\UnitTest\Adapter\Resizer\Abstracts\AbstractResizeAdapterTest;

/**
 * Class ImageMagickResizeAdapterTest.
 */
class ImageMagickResizeAdapterTest extends AbstractResizeAdapterTest
{
    /**
     * Return instance of resizeAdapter.
     *
     * @return ResizeAdapterInterface Resize Adapter
     */
    public function getAdapterInstance()
    {
        if (!file_exists('/usr/bin/convert') || !file_exists('/usr/share/color/icc/colord/sRGB.icc')) {
            $this->markTestSkipped(
                'Both the files /usr/bin/convert and /usr/share/color/icc/colord/sRGB.icc are required.'
            );
        }

        return new ImageMagickResizeAdapter(
            '/usr/bin/convert',
            '/usr/share/color/icc/colord/sRGB.icc'
        );
    }
}
