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

namespace Elcodi\Component\Geo\Entity;

use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;

/**
 * Class ZoneCityMember
 */
class ZoneCityMember extends ZoneMember implements ZoneCityMemberInterface
{
    /**
     * Construct method
     *
     * @param ZoneInterface $zone Zone
     * @param CityInterface $city City
     */
    public function __construct(
        ZoneInterface $zone,
        CityInterface $city
    ) {
        $this->zone = $zone;
        $this->city = $city;
    }

    /**
     * @var CityInterface
     *
     * City
     */
    protected $city;

    /**
     * Get City
     *
     * @return CityInterface City
     */
    public function getCity()
    {
        return $this->city;
    }
}
