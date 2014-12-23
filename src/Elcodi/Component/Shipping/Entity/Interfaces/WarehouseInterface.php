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

namespace Elcodi\Component\Shipping\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Interface WarehouseInterface
 */
interface WarehouseInterface extends EnabledInterface
{
    /**
     * Get Id
     *
     * @return int Id
     */
    public function getId();

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return $this Self object
     */
    public function setId($id);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription();

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * Get Address
     *
     * @return AddressInterface Address
     */
    public function getAddress();

    /**
     * Sets Address
     *
     * @param AddressInterface $address Address
     *
     * @return $this Self object
     */
    public function setAddress($address);
}
