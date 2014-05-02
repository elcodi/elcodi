<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\MediaBundle\Adapter\Resizer\Interfaces;

use Elcodi\MediaBundle\ElcodiMediaImageResizeTypes;
use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;

/**
 * Class ResizerAdapterInterface
 */
interface ResizeAdapterInterface
{
    /**
     * Interface for resize implementations
     *
     * @param ImageInterface $image  Image object
     * @param Integer        $height Height value
     * @param Integer        $width  Width value
     * @param Integer        $type   Type
     *
     * @return ImageInterface
     */
    public function resize(
        ImageInterface $image,
        $height,
        $width,
        $type = ElcodiMediaImageResizeTypes::FORCE_MEASURES
    );
}
 