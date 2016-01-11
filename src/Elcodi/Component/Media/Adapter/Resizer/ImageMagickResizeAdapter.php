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
use Symfony\Component\Process\ProcessBuilder;

use Elcodi\Component\Media\Adapter\Resizer\Interfaces\ResizeAdapterInterface;
use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Class ImageMagickResizerAdapter.
 */
class ImageMagickResizeAdapter implements ResizeAdapterInterface
{
    /**
     * @var string
     *
     * Path of image converter
     */
    private $imageConverterBin;

    /**
     * @var string
     *
     * Default ICC profile path
     */
    private $profile;

    /**
     * Constructor method.
     *
     * @param string $imageConverterBin Path of image converter
     * @param string $profile           Default ICC profile path
     */
    public function __construct($imageConverterBin, $profile)
    {
        $this->imageConverterBin = $imageConverterBin;
        $this->profile = $profile;
    }

    /**
     * Generate Thumbnail images with ImageMagick.
     *
     * @param string $imageData Image Data
     * @param int    $height    Height value
     * @param int    $width     Width value
     * @param int    $type      Type
     *
     * @return string Resized image data
     *
     * @throws \RuntimeException
     */
    public function resize(
        $imageData,
        $height,
        $width,
        $type = ElcodiMediaImageResizeTypes::FORCE_MEASURES
    ) {
        if (ElcodiMediaImageResizeTypes::NO_RESIZE === $type) {
            return $imageData;
        }

        $originalFile = new File(tempnam(sys_get_temp_dir(), '_original'));
        $resizedFile = new File(tempnam(sys_get_temp_dir(), '_resize'));

        file_put_contents($originalFile, $imageData);

        //ImageMagick params
        $pb = new ProcessBuilder();
        $pb
            ->add($this->imageConverterBin)
            //Crop white surrounding image
            ->add($originalFile->getPathname())
            //We use a CMKY profile and a sRGB
            ->add('-profile')
            ->add($this->profile);

        //Lanczos filter for reduction
        $pb->add('-filter')->add('Lanczos');

        if ($width == 0) {
            $width = '';
        }

        if ($height == 0) {
            $height = '';
        }

        /**
         * Apply some filters depending on type of resizing.
         */
        if ($width || $height) {
            $pb->add('-resize');

            switch ($type) {

                case ElcodiMediaImageResizeTypes::INSET:

                    $pb
                        ->add($width . 'x' . $height);

                    break;

                case ElcodiMediaImageResizeTypes::INSET_FILL_WHITE:
                    $pb
                        ->add($width . 'x' . $height)
                        ->add('-gravity')
                        ->add('center')
                        ->add('-extent')
                        ->add($width . 'x' . $height);

                    break;

                case ElcodiMediaImageResizeTypes::OUTBOUNDS_FILL_WHITE:

                    $pb
                        ->add($width . 'x' . $height . '');

                    break;

                case ElcodiMediaImageResizeTypes::OUTBOUND_CROP:
                    $pb
                        ->add($width . 'x' . $height . '^')
                        ->add('-gravity')
                        ->add('center')
                        ->add('-crop')
                        ->add($width . 'x' . $height . '+0+0');

                    break;

                case ElcodiMediaImageResizeTypes::FORCE_MEASURES:
                default:

                    $pb
                        ->add($width . 'x' . $height . '!');
                    break;
            }
        }

        $proc = $pb
            ->add($resizedFile->getPathname())
            ->getProcess();

        $proc->run();

        if (false !== strpos($proc->getOutput(), 'ERROR')) {
            throw new \RuntimeException($proc->getOutput());
        }

        $imageContent = file_get_contents($resizedFile->getRealPath());

        unlink($originalFile);
        unlink($resizedFile);

        return $imageContent;
    }
}
