<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Geo\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class CartLineOnAddEvent.
 */
final class AddressOnCloneEvent extends Event
{
    /**
     * @var AddressInterface
     *
     * The original address being cloned
     */
    private $originalAddress;

    /**
     * @var AddressInterface
     *
     * The address clone
     */
    private $clonedAddress;

    /**
     * Builds a new address on clone event.
     *
     * @param AddressInterface $originalAddress The original address
     * @param AddressInterface $clonedAddress   The new address clone
     */
    public function __construct(
        AddressInterface $originalAddress,
        AddressInterface $clonedAddress
    ) {
        $this->originalAddress = $originalAddress;
        $this->clonedAddress = $clonedAddress;
    }

    /**
     * Get the original address.
     *
     * @return AddressInterface
     */
    public function getOriginalAddress()
    {
        return $this->originalAddress;
    }

    /**
     * Get the cloned address.
     *
     * @return AddressInterface
     */
    public function getClonedAddress()
    {
        return $this->clonedAddress;
    }
}
