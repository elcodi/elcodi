<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\UserBundle\Entity;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\UserBundle\Entity\Interfaces\AddressInterface;

/**
 * Address
 */
class Address extends AbstractEntity implements AddressInterface
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Address
     */
    protected $address;

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string
     *
     * @return Address self Object
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * To string
     *
     * @return string address
     */
    public function __toString()
    {
        return $this->address;
    }
}
