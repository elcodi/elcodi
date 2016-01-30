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

namespace Elcodi\Component\Metric\Core\Entity\Interfaces;

/**
 * Interface EntryInterface.
 */
interface EntryInterface
{
    /**
     * Get Token.
     *
     * @return string Token
     */
    public function getToken();

    /**
     * Get Event.
     *
     * @return string Event
     */
    public function getEvent();

    /**
     * Get Value.
     *
     * @return string Value
     */
    public function getValue();

    /**
     * Get Type.
     *
     * @return int Type
     */
    public function getType();

    /**
     * Get CreatedAt.
     *
     * @return \DateTime|null CreatedAt
     */
    public function getCreatedAt();
}
