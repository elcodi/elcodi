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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Media\Adapter\Resizer\Interfaces;

use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class ResizerAdapterInterface
 */
interface ResizeAdapterInterface
{
    /**
     * Interface for resize implementations
     *
     * @param string  $imageData Image Data
     * @param Integer $height    Height value
     * @param Integer $width     Width value
     * @param Integer $type      Type
     *
     * @return string Resized image data
     */
    public function resize(
        $imageData,
        $height,
        $width,
        $type = ElcodiMediaImageResizeTypes::FORCE_MEASURES
    );
}
