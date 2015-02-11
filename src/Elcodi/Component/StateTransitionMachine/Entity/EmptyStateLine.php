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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\StateTransitionMachine\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;

/**
 * Class EmptyStateLine
 */
class EmptyStateLine implements StateLineInterface
{
    use IdentifiableTrait, DateTimeTrait;

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return;
    }

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        return $this;
    }

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return;
    }

    /**
     * Create empty object
     *
     * @return self new instance
     */
    public static function create()
    {
        return new self();
    }
}
