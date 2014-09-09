<?php

/**
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

namespace Elcodi\Component\Core\Entity\Traits;

/**
 * Trait adding enabled/disabled fields and methods
 */
trait EnabledTrait
{
    /**
     * @var boolean
     *
     * Enabled
     */
    protected $enabled;

    /**
     * Set if is enabled
     *
     * @param boolean $enabled enabled value
     *
     * @return $this self Object
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get is enabled
     *
     * @return boolean is enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Enable
     *
     * @return $this self Object
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable
     *
     * @return $this self Object
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }
}
