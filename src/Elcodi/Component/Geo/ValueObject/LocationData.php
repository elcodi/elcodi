<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Geo\ValueObject;

/**
 * Class LocationData value object.
 *
 * Saves all the data for a location
 */
class LocationData
{
    /**
     * @var string
     *
     * The identifier
     */
    private $id;

    /**
     * @var string
     *
     * The name
     */
    private $name;

    /**
     * @var string
     *
     * The code
     */
    private $code;

    /**
     * @var string
     *
     * The type
     */
    private $type;

    /**
     * Builds a new Location data.
     *
     * @param string $id   The identifier
     * @param string $name The name
     * @param string $code The code
     * @param string $type The type
     */
    public function __construct(
        $id,
        $name,
        $code,
        $type
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->type = $type;
    }

    /**
     * Get the id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
