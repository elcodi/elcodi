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

namespace Elcodi\Component\Geo\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Geo\ElcodiGeoEvents;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Event\AddressOnCloneEvent;

/**
 * Class CartLineEventDispatcher.
 */
class AddressEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatches the address on clone event.
     *
     * @param AddressInterface $originalAddress The original address
     * @param AddressInterface $clonedAddress   The cloned address
     *
     * @return $this Self object
     */
    public function dispatchAddressOnCloneEvent(
        AddressInterface $originalAddress,
        AddressInterface $clonedAddress
    ) {
        $this->eventDispatcher->dispatch(
            ElcodiGeoEvents::ADDRESS_ONCLONE,
            new AddressOnCloneEvent(
                $originalAddress,
                $clonedAddress
            )
        );

        return $this;
    }
}
