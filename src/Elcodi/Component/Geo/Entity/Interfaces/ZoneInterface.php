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

namespace Elcodi\Component\Geo\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface ZoneInterface
 */
interface ZoneInterface extends EnabledInterface
{
    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code);

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Zone members
     *
     * @param Collection $members Zone Members
     *
     * @return $this Self object
     */
    public function setMembers(Collection $members);

    /**
     * Get Zone members
     *
     * @return Collection Zone members
     */
    public function getMembers();

    /**
     * Add zone member
     *
     * @param ZoneMemberInterface $member Zone member
     *
     * @return $this Self object
     */
    public function addMember(ZoneMemberInterface $member);

    /**
     * Removed zone member
     *
     * @param ZoneMemberInterface $member Zone member
     *
     * @return $this Self object
     */
    public function removeMember(ZoneMemberInterface $member);
}
