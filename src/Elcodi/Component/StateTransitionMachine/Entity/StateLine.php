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

namespace Elcodi\Component\StateTransitionMachine\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;

/**
 * Class StateLine
 */
class StateLine implements StateLineInterface
{
    use DateTimeTrait;

    /**
     * @var integer
     *
     * Identifier
     */
    protected $id;

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
     * Get Id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
        $this->description = $description;

        return $this;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
