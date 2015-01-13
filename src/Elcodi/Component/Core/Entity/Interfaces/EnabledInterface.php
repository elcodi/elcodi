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

namespace Elcodi\Component\Core\Entity\Interfaces;

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
     * @return $this Self object
     */
    public function setEnabled($enabled);

    /**
     * Get if entity is enabled
     *
     * @return boolean Enabled
     */
    public function isEnabled();
}
