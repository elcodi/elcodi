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

namespace Elcodi\Component\Shipping\Entity;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface;

/**
 * Class Warehouse
 */
class Warehouse implements WarehouseInterface
{
    use EnabledTrait;

    /**
     * @var integer
     *
     * id
     */
    protected $id;

    /**
     * @var string
     *
     * name
     */
    protected $name;

    /**
     * @var string
     *
     * description
     */
    protected $description;

    /**
     * @var AddressInterface
     *
     * Address
     */
    protected $address;

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
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
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
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get Address
     *
     * @return AddressInterface Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets Address
     *
     * @param AddressInterface $address Address
     *
     * @return $this Self object
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}
