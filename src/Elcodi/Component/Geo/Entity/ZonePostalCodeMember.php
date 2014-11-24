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

use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface;

/**
 * Class ZonePostalCodeMember
 */
class ZonePostalCodeMember extends ZoneMember implements ZonePostalCodeMemberInterface
{
    /**
     * Construct method
     *
     * @param ZoneInterface       $zone       Zone
     * @param PostalCodeInterface $postalCode Postalcode
     */
    public function __construct(
        ZoneInterface $zone,
        PostalCodeInterface $postalCode
    )
    {
        $this->zone = $zone;
        $this->postalCode = $postalCode;
    }

    /**
     * @var PostalcodeInterface
     *
     * Postalcode
     */
    protected $postalCode;

    /**
     * Get Postalcode
     *
     * @return PostalcodeInterface Postalcode
     */
    public function getPostalcode()
    {
        return $this->postalCode;
    }
}
