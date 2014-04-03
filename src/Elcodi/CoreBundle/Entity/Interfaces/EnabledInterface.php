<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Entity\Interfaces;

/**
 * Class EnabledInterface
 */
interface EnabledInterface
{
    /**
     * Set isEnabled
     *
     * @param boolean $enabled enabled value
     *
     * @return Object self Object
     */
    public function setEnabled($enabled);

    /**
     * Get if entity is enabled
     *
     * @return boolean Enabled
     */
    public function isEnabled();
}
