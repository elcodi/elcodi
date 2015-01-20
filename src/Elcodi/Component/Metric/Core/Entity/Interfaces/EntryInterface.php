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

namespace Elcodi\Component\Metric\Core\Entity\Interfaces;

/**
 * Interface EntryInterface
 */
interface EntryInterface
{
    /**
     * Get Context
     *
     * @return string Context
     */
    public function getContext();

    /**
     * Get CreatedAt
     *
     * @return mixed CreatedAt
     */
    public function getCreatedAt();

    /**
     * Get Event
     *
     * @return string Event
     */
    public function getEvent();

    /**
     * Get Token
     *
     * @return string Token
     */
    public function getToken();
}
