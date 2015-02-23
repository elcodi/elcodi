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
 
namespace Elcodi\Component\Media\EventDispatcher;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Event\ImageUploadedEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Media\ElcodiMediaEvents;

/**
 * Class MediaEventDispatcher
 */
class MediaEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Create image pre uploaded event
     *
     * @param ImageInterface $image Image
     *
     * @return $this self Object
     */
    public function dispatchImagePreUploadEvent(ImageInterface $image)
    {
        $imageUploadedEvent = new ImageUploadedEvent($image);

        $this->eventDispatcher->dispatch(
            ElcodiMediaEvents::IMAGE_PREUPLOAD,
            $imageUploadedEvent
        );

        return $this;
    }

    /**
     * Create image on uploaded event
     *
     * @param ImageInterface $image Image
     *
     * @return $this self Object
     */
    public function dispatchImageOnUploadEvent(ImageInterface $image)
    {
        $imageUploadedEvent = new ImageUploadedEvent($image);

        $this->eventDispatcher->dispatch(
            ElcodiMediaEvents::IMAGE_ONUPLOAD,
            $imageUploadedEvent
        );

        return $this;
    }
}
