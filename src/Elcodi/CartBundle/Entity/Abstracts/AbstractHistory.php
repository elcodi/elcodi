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

namespace Elcodi\CartBundle\Entity\Abstracts;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;

/**
 * Base Web User
 */
abstract class AbstractHistory extends AbstractEntity
{
    use DateTimeTrait;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $description;

    /**
     * Set state
     *
     * @param string $state State
     *
     * @return AbstractHistory self Object
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return AbstractHistory self Object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
