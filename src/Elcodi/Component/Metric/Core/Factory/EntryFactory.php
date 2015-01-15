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
 */

namespace Elcodi\Component\Metric\Core\Factory;

use DateTime;

use Elcodi\Component\Metric\Core\Entity\Entry;

/**
 * Class EntryFactory
 */
class EntryFactory
{
    /**
     * Create entry
     *
     * @param string   $token     Token
     * @param string   $event     Event
     * @param string   $context   Context
     * @param DateTime $createdAt Created At
     *
     * @return Entry new entry instance
     */
    public function create(
        $token,
        $event,
        $context,
        $createdAt
    )
    {
        return new Entry(
            $token,
            $event,
            $context,
            $createdAt
        );
    }
}
