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

namespace Elcodi\Component\StateMachine\Entity;

use Elcodi\Component\StateMachine\Entity\Interfaces\StateLineInterface;

/**
 * Class StateLine
 */
class StateLine implements StateLineInterface
{
    /**
     * @var string
     *
     * State name
     */
    protected $name;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * Construct
     *
     * @var string $name        State name
     * @var string $description State description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
