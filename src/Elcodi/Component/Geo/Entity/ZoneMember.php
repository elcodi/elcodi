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

use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberInterface;

/**
 * Class ZoneMember
 */
abstract class ZoneMember implements ZoneMemberInterface
{
    /**
     * @var Integer
     *
     * Id
     */
    protected $id;

    /**
     * @var ZoneInterface
     *
     * Zone
     */
    protected $zone;

    /**
     * Get id
     *
     * @return integer Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Zone
     *
     * @return ZoneInterface Zone
     */
    public function getZone()
    {
        return $this->zone;
    }
}
