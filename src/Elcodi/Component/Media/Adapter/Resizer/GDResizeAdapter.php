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

namespace Elcodi\Component\Media\Adapter\Resizer;

use Symfony\Component\HttpFoundation\File\File;

use Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\Component\Media\Adapter\Resizer\Model\Dimensions;
use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class GDResizeAdapter.
 */
class GDResizeAdapter implements ResizeAdapterInterface
{
    /**
     * Interface for resize implementations.
     *
     * @param string $imageData Image Data
     * @param int    $height    Height value
     * @param int    $width     Width value
     * @param int    $type      Type
     *
     * @return string Resized image data
     */
    public function resize(
        $imageData,
        $height,
        $width,
        $type = ElcodiMediaImageResizeTypes::FORCE_MEASURES
    ) {
        $originalResource = imagecreatefromstring($imageData);
        $originalWidth = imagesx($originalResource);
        $originalHeight = imagesy($originalResource);
        $dimensions = Dimensions::create(
            $originalWidth,
            $originalHeight,
            $width,
            $height,
            $type
        );

        $newResource = imagecreatetruecolor(
            $dimensions->getDstFrameX(),
            $dimensions->getDstFrameY()
        );

        $backgroundColor = imagecolorallocate($newResource, 255, 255, 255);
        imagefill($newResource, 0, 0, $backgroundColor);

        imagecopyresampled(
            $newResource,
            $originalResource,
            $dimensions->getDstX(),
            $dimensions->getDstY(),
            $dimensions->getSrcX(),
            $dimensions->getSrcY(),
            $dimensions->getDstWidth(),
            $dimensions->getDstHeight(),
            $dimensions->getSrcWidth(),
            $dimensions->getSrcHeight()
        );

        ob_start();
        imagejpeg($newResource);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
