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

use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;

/**
 * Class ZoneCountryMember
 */
class ZoneCountryMember extends ZoneMember implements ZoneCountryMemberInterface
{
    /**
     * Construct method
     *
     * @param ZoneInterface    $zone    Zone
     * @param CountryInterface $country Country
     */
    public function __construct(
        ZoneInterface $zone,
        CountryInterface $country
    ) {
        $this->zone = $zone;
        $this->country = $country;
    }

    /**
     * @var CountryInterface
     *
     * Country
     */
    protected $country;

    /**
     * Get Country
     *
     * @return CountryInterface Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
