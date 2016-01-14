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

namespace Elcodi\Component\Media;

/**
 * Class ElcodiMediaEvents.
 */
final class ElcodiMediaEvents
{
    /**
     * This event is fired each time an image is going to be uploaded.
     *
     * event.name : image.preupload
     * event.class : ImageUploadEvent
     */
    const IMAGE_PREUPLOAD = 'image.preupload';

    /**
     * This event is fired each time an image has been uploaded.
     *
     * event.name : image.onupload
     * event.class : ImageUploadEvent
     */
    const IMAGE_ONUPLOAD = 'image.onupload';
}
