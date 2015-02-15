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

namespace Elcodi\Component\Geo\Builder;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Factory\LocationFactory;

/**
 * Class GeoBuilder
 */
class GeoBuilder
{
    /**
     * @var LocationFactory
     *
     * Location factory
     */
    protected $locationFactory;

    /**
     * @var array
     *
     * Location collection
     */
    protected $locations;

    /**
     * @param LocationFactory $locationFactory Location factory
     */
    public function __construct(LocationFactory $locationFactory)
    {
        $this->locationFactory = $locationFactory;

        $this->locations = array();
    }

    public function addLocation($id, $name, $code, $type, LocationInterface $parent = null)
    {
        return $this
            ->locationFactory
            ->create();
    }
}
