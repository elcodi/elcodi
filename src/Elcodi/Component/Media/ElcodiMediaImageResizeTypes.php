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
 * Class ElcodiMediaImageResizeTypes.
 */
final class ElcodiMediaImageResizeTypes
{
    /**
     * @var int
     *
     * Do not resize the image
     */
    const NO_RESIZE = 0;

    /**
     * @var int
     *
     * Resize mode FORCE_MEASURES sets the image to the desired size.
     * DOES NOT preserve original aspect ratio.
     * Best for fixed size images like banners
     */
    const FORCE_MEASURES = 1;

    /**
     * @var int
     *
     * Resize mode INSET sets the image to the desired size.
     * Preserves original aspect ratio so it might not fill the box.
     * Best for large thumbnails
     */
    const INSET = 2;

    /**
     * @var int
     *
     * Resize mode INSET_FILL_WHITE sets the image to the desired size.
     * Preserves original aspect ratio and adds white color to the background in order to fill the box.
     * Best for small thumbnails
     */
    const INSET_FILL_WHITE = 3;

    /**
     * @var int
     *
     * Outbound resizing
     */
    const OUTBOUNDS_FILL_WHITE = 4;

    /**
     * @var int
     *
     * Resize mode 5 sets the image to the desired size.
     * Preserves original aspect ratio and crops image for only get this area.
     */
    const OUTBOUND_CROP = 5;
}
