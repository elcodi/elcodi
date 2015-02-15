<?php

namespace Elcodi\Component\Geo\ValueObject;

/**
 * Class LocationData value object
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
    protected $id;

    /**
     * @var string
     *
     * The name
     */
    protected $name;

    /**
     * @var string
     *
     * The code
     */
    protected $code;

    /**
     * @var string
     *
     * The type
     */
    protected $type;

    /**
     * Builds a new Location data
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
        $this->id   = $id;
        $this->name = $name;
        $this->code = $code;
        $this->type = $type;
    }

    /**
     * Get the id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}