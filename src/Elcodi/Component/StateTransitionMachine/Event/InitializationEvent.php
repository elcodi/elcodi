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

namespace Elcodi\Component\StateTransitionMachine\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StatefulInterface;

/**
 * Class InitializationEvent
 */
class InitializationEvent extends Event
{
    /**
     * @var StatefulInterface
     *
     * Object
     */
    protected $object;

    /**
     * Construct
     *
     * @param StatefulInterface $object Object
     */
    public function __construct(StatefulInterface $object)
    {
        $this->object = $object;
    }

    /**
     * Get Object
     *
     * @return StatefulInterface Object
     */
    public function getObject()
    {
        return $this->object;
    }
}
