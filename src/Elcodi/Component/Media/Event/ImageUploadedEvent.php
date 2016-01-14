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

namespace Elcodi\Component\Media\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Class ImageUploadedEvent.
 */
final class ImageUploadedEvent extends Event
{
    /**
     * @var ImageInterface
     *
     * Image
     */
    private $image;

    /**
     * Construct.
     *
     * @param ImageInterface $image Image
     */
    public function __construct(ImageInterface $image)
    {
        $this->image = $image;
    }

    /**
     * Get image.
     *
     * @return ImageInterface Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
