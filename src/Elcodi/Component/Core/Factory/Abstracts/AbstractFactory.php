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

namespace Elcodi\Component\Core\Factory\Abstracts;

use DateTime;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Core\Factory\Traits\EntityNamespaceTrait;

/**
 * Class AbstractFactory.
 *
 * Entity factories create a pristine instance for the specified Entity
 *
 * Entity initialization logic should be placed right here.
 *
 * Injected entity namespace should not be duplicated.
 */
abstract class AbstractFactory
{
    use EntityNamespaceTrait;

    /**
     * @var DateTimeFactory
     *
     * DateTime Factory
     */
    private $dateTimeFactory;

    /**
     * Sets DateTimeFactory.
     *
     * @param DateTimeFactory $dateTimeFactory DateTimeFactory
     *
     * @return $this Self object
     */
    public function setDateTimeFactory(DateTimeFactory $dateTimeFactory)
    {
        $this->dateTimeFactory = $dateTimeFactory;

        return $this;
    }

    /**
     * Get now.
     *
     * @return DateTime Now
     */
    public function now()
    {
        return $this
            ->dateTimeFactory
            ->create();
    }

    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always return an empty instance of the related Entity
     * and must initialize it in a consistent state
     *
     * @return object Empty entity
     */
    abstract public function create();
}
