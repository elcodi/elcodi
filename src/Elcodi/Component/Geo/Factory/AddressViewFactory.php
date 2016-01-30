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

namespace Elcodi\Component\Geo\Factory;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\View\AddressView;

/**
 * Class AddressViewFactory.
 */
class AddressViewFactory
{
    /**
     * @var LocationProviderAdapterInterface
     *
     * A location provider
     */
    private $locationProvider;

    /**
     * Builds a new factory.
     *
     * @param LocationProviderAdapterInterface $locationProvider A location provider
     */
    public function __construct(LocationProviderAdapterInterface $locationProvider)
    {
        $this->locationProvider = $locationProvider;
    }

    /**
     * Builds a new address view.
     *
     * @param AddressInterface $address The address to be converted on view.
     *
     * @return AddressView
     */
    public function create(AddressInterface $address)
    {
        return new AddressView(
            $address,
            $this->locationProvider
        );
    }
}
