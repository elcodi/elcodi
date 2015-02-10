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

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberInterface;

/**
 * Class Zone
 */
class Zone implements ZoneInterface
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var Collection
     *
     * Zone members
     */
    protected $members;

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
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
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Zone members
     *
     * @param Collection $members Zone Members
     *
     * @return $this Self object
     */
    public function setMembers(Collection $members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Get Zone members
     *
     * @return Collection Zone members
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add zone member
     *
     * @param ZoneMemberInterface $member Zone member
     *
     * @return $this Self object
     */
    public function addMember(ZoneMemberInterface $member)
    {
        if (!$this->members->contains($member)) {

            $this
                ->members
                ->add($member);
        }

        return $this;
    }

    /**
     * Removed zone member
     *
     * @param ZoneMemberInterface $member Zone member
     *
     * @return $this Self object
     */
    public function removeMember(ZoneMemberInterface $member)
    {
        $this
            ->members
            ->removeElement($member);

        return $this;
    }
}
