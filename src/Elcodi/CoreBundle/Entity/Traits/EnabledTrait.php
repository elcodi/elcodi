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
     */
    protected $enabled;

    /**
     * @param boolean $enabled enabled value
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return $this
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * @return $this
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }
}
