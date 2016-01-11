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

namespace Elcodi\Component\Core\Entity\Interfaces;

use DateTime;

/**
 * Interface DateTimeInterface.
 */
interface DateTimeInterface
{
    /**
     * Set locally created at value.
     *
     * @param DateTime $createdAt Created at value
     *
     * @return $this Self object
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * Return created_at value.
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set locally updated at value.
     *
     * @param DateTime $updatedAt Updated at value
     *
     * @return $this Self object
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * Return updated_at value.
     *
     * @return DateTime
     */
    public function getUpdatedAt();
}
