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

namespace Elcodi\Component\Geo\Entity;

use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface;

/**
 * Class ZoneProvinceMember
 */
class ZoneProvinceMember extends ZoneMember implements ZoneProvinceMemberInterface
{
    /**
     * Construct method
     *
     * @param ZoneInterface     $zone     Zone
     * @param ProvinceInterface $province Province
     */
    public function __construct(
        ZoneInterface $zone,
        ProvinceInterface $province
    )
    {
        $this->zone = $zone;
        $this->province = $province;
    }

    /**
     * @var ProvinceInterface
     *
     * Province
     */
    protected $province;

    /**
     * Get Province
     *
     * @return ProvinceInterface Province
     */
    public function getProvince()
    {
        return $this->province;
    }
}
