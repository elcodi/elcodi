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
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;

/**
 * Interface CarrierRangeInterface
 */
interface CarrierRangeInterface extends EnabledInterface
{
    /**
     * Get Carrier
     *
     * @return CarrierInterface Carrier
     */
    public function getCarrier();

    /**
     * Sets Carrier
     *
     * @param CarrierInterface $carrier Carrier
     *
     * @return $this Self object
     */
    public function setCarrier($carrier);

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
     * Get FromZone
     *
     * @return ZoneInterface FromZone
     */
    public function getFromZone();

    /**
     * Sets FromZone
     *
     * @param ZoneInterface $fromZone FromZone
     *
     * @return $this Self object
     */
    public function setFromZone($fromZone);

    /**
     * Get ToZone
     *
     * @return ZoneInterface ToZone
     */
    public function getToZone();

    /**
     * Sets ToZone
     *
     * @param ZoneInterface $toZone ToZone
     *
     * @return $this Self object
     */
    public function setToZone($toZone);

    /**
     * Set price
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this self Object
     */
    public function setPrice(MoneyInterface $amount);

    /**
     * Get price
     *
     * @return MoneyInterface Price
     */
    public function getPrice();
}
