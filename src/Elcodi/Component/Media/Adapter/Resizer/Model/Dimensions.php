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

namespace Elcodi\Component\Media\Adapter\Resizer\Model;

use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class Dimensions.
 */
class Dimensions
{
    /**
     * @var float
     *
     * originalWidth
     */
    private $originalWidth;

    /**
     * @var float
     *
     * originalHeight
     */
    private $originalHeight;

    /**
     * @var float
     *
     * originalAspectRatio
     */
    private $originalAspectRatio;

    /**
     * @var float
     *
     * srcY
     */
    private $srcY;

    /**
     * @var float
     *
     * srcX
     */
    private $srcX;

    /**
     * @var
     *
     * srcWidth
     */
    private $srcWidth;

    /**
     * @var float
     *
     * srcHeight
     */
    private $srcHeight;

    /**
     * @var float
     *
     * dstY
     */
    private $dstY;

    /**
     * @var float
     *
     * dstX
     */
    private $dstX;

    /**
     * @var float
     *
     * dstWidth
     */
    private $dstWidth;

    /**
     * @var float
     *
     * dstHeight
     */
    private $dstHeight;

    /**
     * @var float
     *
     * dstFrameX
     */
    private $dstFrameX;

    /**
     * @var float
     *
     * dstFrameY
     */
    private $dstFrameY;

    /**
     * Construct.
     *
     * @param float $originalWidth  Original width
     * @param float $originalHeight Original height
     * @param float $newWidth       New width
     * @param float $newHeight      New height
     * @param int   $type           Resize type
     */
    private function __construct(
        $originalWidth,
        $originalHeight,
        $newWidth,
        $newHeight,
        $type
    ) {
        $this->originalWidth = $originalWidth;
        $this->originalHeight = $originalHeight;
        $this->originalAspectRatio = $originalWidth / $originalHeight;

        $this->resolveDimensions(
            $newWidth,
            $newHeight,
            $type
        );
    }

    /**
     * Resolve dimensions.
     *
     * @param float $newWidth  New width
     * @param float $newHeight New height
     * @param int   $type      Resize type
     *
     * @return $this Self object
     */
    public function resolveDimensions(
        $newWidth,
        $newHeight,
        $type
    ) {
        $this->dstX = 0;
        $this->dstY = 0;
        $this->dstWidth = $newWidth;
        $this->dstHeight = $newHeight;
        $this->dstFrameX = $newWidth;
        $this->dstFrameY = $newHeight;

        $this->srcX = 0;
        $this->srcY = 0;
        $this->srcWidth = $this->originalWidth;
        $this->srcHeight = $this->originalHeight;

        if ($type == ElcodiMediaImageResizeTypes::NO_RESIZE) {
            $this->dstWidth = $this->originalWidth;
            $this->dstHeight = $this->originalHeight;
            $this->dstFrameX = $this->originalWidth;
            $this->dstFrameY = $this->originalHeight;
        } elseif (in_array($type, [
            ElcodiMediaImageResizeTypes::INSET,
            ElcodiMediaImageResizeTypes::INSET_FILL_WHITE,
            ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE,
            ElcodiMediaImageResizeTypes::OUTBOUND_CROP,
        ])) {
            $newAspectRatio = $newWidth / $newHeight;
            if ($newAspectRatio == $this->originalAspectRatio) {
                $height = $newHeight;
                $width = $newWidth;
            } elseif (
                ($newAspectRatio > $this->originalAspectRatio) ^
                (in_array($type, [
                    ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE,
                    ElcodiMediaImageResizeTypes::OUTBOUND_CROP,
                ])
                )
            ) {
                $height = $newHeight;
                $width = $newHeight * $this->originalAspectRatio;
            } else {
                $width = $newWidth;
                $height = $newWidth / $this->originalAspectRatio;
            }
            $changeRatio = $height / $this->originalHeight;

            if ($type == ElcodiMediaImageResizeTypes::OUTBOUND_CROP) {
                $this->srcX = (($width - $newWidth) / 2) / $changeRatio;
                $this->srcY = (($height - $newHeight) / 2) / $changeRatio;
                $this->srcWidth = $newWidth / $changeRatio;
                $this->srcHeight = $newHeight / $changeRatio;
            }

            if ($type == ElcodiMediaImageResizeTypes::INSET_FILL_WHITE) {
                $this->dstX = ($newWidth - $width) / 2;
                $this->dstY = ($newHeight - $height) / 2;
            }

            if (in_array($type, [
                ElcodiMediaImageResizeTypes::INSET,
                ElcodiMediaImageResizeTypes::INSET_FILL_WHITE,
                ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE,
            ])) {
                $this->dstWidth = $width;
                $this->dstHeight = $height;
            }

            if (in_array($type, [
                ElcodiMediaImageResizeTypes::INSET,
                ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE,
            ])) {
                $this->dstFrameX = $width;
                $this->dstFrameY = $height;
            }
        }

        return $this;
    }

    /**
     * Get OriginalWidth.
     *
     * @return float OriginalWidth
     */
    public function getOriginalWidth()
    {
        return $this->originalWidth;
    }

    /**
     * Get OriginalHeight.
     *
     * @return float OriginalHeight
     */
    public function getOriginalHeight()
    {
        return $this->originalHeight;
    }

    /**
     * Get OriginalAspectRatio.
     *
     * @return float OriginalAspectRatio
     */
    public function getOriginalAspectRatio()
    {
        return $this->originalAspectRatio;
    }

    /**
     * Get SrcY.
     *
     * @return float SrcY
     */
    public function getSrcY()
    {
        return $this->srcY;
    }

    /**
     * Get SrcX.
     *
     * @return float SrcX
     */
    public function getSrcX()
    {
        return $this->srcX;
    }

    /**
     * Get SrcWidth.
     *
     * @return float SrcWidth
     */
    public function getSrcWidth()
    {
        return $this->srcWidth;
    }

    /**
     * Get SrcHeight.
     *
     * @return float SrcHeight
     */
    public function getSrcHeight()
    {
        return $this->srcHeight;
    }

    /**
     * Get DstY.
     *
     * @return float DstY
     */
    public function getDstY()
    {
        return $this->dstY;
    }

    /**
     * Get DstX.
     *
     * @return float DstX
     */
    public function getDstX()
    {
        return $this->dstX;
    }

    /**
     * Get DstWidth.
     *
     * @return float DstWidth
     */
    public function getDstWidth()
    {
        return $this->dstWidth;
    }

    /**
     * Get DstHeight.
     *
     * @return float DstHeight
     */
    public function getDstHeight()
    {
        return $this->dstHeight;
    }

    /**
     * Get DstFrameX.
     *
     * @return float DstFrameX
     */
    public function getDstFrameX()
    {
        return $this->dstFrameX;
    }

    /**
     * Get DstFrameY.
     *
     * @return float DstFrameY
     */
    public function getDstFrameY()
    {
        return $this->dstFrameY;
    }

    /**
     * @param float $originalWidth  Original width
     * @param float $originalHeight Original height
     * @param float $newWidth       New width
     * @param float $newHeight      New height
     * @param int   $type           Resize type
     *
     * @return self New instance
     */
    public static function create(
        $originalWidth,
        $originalHeight,
        $newWidth,
        $newHeight,
        $type
    ) {
        return new self(
            $originalWidth,
            $originalHeight,
            $newWidth,
            $newHeight,
            $type
        );
    }
}
