<?php

/**
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

use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface;

/**
 * Class ZoneStateMember
 */
class ZoneStateMember extends ZoneMember implements ZoneStateMemberInterface
{
    /**
     * Construct method
     *
     * @param ZoneInterface  $zone  Zone
     * @param StateInterface $state State
     */
    public function __construct(
        ZoneInterface $zone,
        StateInterface $state
    )
    {
        $this->zone = $zone;
        $this->state = $state;
    }

    /**
     * @var StateInterface
     *
     * State
     */
    protected $state;

    /**
     * Get State
     *
     * @return StateInterface State
     */
    public function getState()
    {
        return $this->state;
    }
}
