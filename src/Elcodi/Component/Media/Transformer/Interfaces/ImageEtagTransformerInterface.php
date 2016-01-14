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

namespace Elcodi\Component\Media\Transformer\Interfaces;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Interface ImageEtagTransformerInterface.
 */
interface ImageEtagTransformerInterface
{
    /**
     * Transforms an Image with some resizing information into an ETag.
     *
     * @param ImageInterface $image  Image
     * @param string         $height Height
     * @param string         $width  Width
     * @param string         $type   Type of resizing
     *
     * @return string ETag generated
     */
    public function transform(
        ImageInterface $image,
        $height,
        $width,
        $type
    );
}
