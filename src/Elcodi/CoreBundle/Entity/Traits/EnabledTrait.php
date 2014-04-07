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

namespace Elcodi\CoreBundle\Entity\Traits;

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
     * @return Object self Object
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
     * @return Object self Object
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable
     *
     * @return Object self Object
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }
}
